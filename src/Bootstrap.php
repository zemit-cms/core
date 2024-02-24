<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Phalcon\Application\AbstractApplication;
use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events;
use Phalcon\Http\ResponseInterface;
use Zemit\Support\Helper;
use Zemit\Config\ConfigInterface;
use Zemit\Cli\Console;
use Zemit\Events\EventsAwareTrait;
use Zemit\Mvc\Application;
use Zemit\Provider\Config\ServiceProvider as ConfigServiceProvider;
use Zemit\Provider\Router\ServiceProvider as RouterServiceProvider;
use Zemit\Router\RouterInterface;
use Zemit\Support\Php;
use Docopt;

/**
 * Zemit Core's Bootstrap for the MVC Application & CLI Console mode
 */
class Bootstrap
{
    use EventsAwareTrait;
    
    public const MODE_CLI = 'cli';
    public const MODE_MVC = 'mvc';
    
    public const MODE_DEFAULT = self::MODE_MVC;
    public const MODE_CONSOLE = self::MODE_CLI;
    
    public string $mode;
    
    public ?array $args;
    
    public DiInterface $di;
    
    public ConfigInterface $config;
    
    public RouterInterface $router;
    
    public ?ResponseInterface $response;
    
    public string $cliDoc = <<<DOC
Zemit CLI

Usage:
  zemit <module> <task> [<action>] [--help | --quiet | --verbose] [--debug] [--format=<format>] [<params>...]
  zemit (-h | --help)
  zemit (-v | --version)
  zemit (-i | --info)

Options:
  -h --help               show this help message
  -v --version            print version number
  -i --info               print information
  -q --quiet              suppress output
  -V --verbose            increase verbosity
  -d --debug              enable debug mode
  --format=<format>       change output returned value format (json, xml, serialized, raw, dump)

Tasks:
  cache                  Wipe the cache
  cron                   Run the scheduled task
  database               Create, optimize, truncate or drop tables within the database
  data-life-cycle        Delete old data based on the data life cycle definitions
  scaffold               Generating files and folders structure
  test                   Return the memory usage to see if the CLI works
  user                   Manage the users and passwords

DOC;
    
    /**
     * @throws Exception
     */
    public function __construct(string $mode = null)
    {
        $this->setMode($mode);
        $this->setEventsManager(new Events\Manager());
        $this->setDI();
        $this->initialize();
        $this->registerConfig();
        $this->registerServices();
        $this->bootServices();
        $this->registerModules();
        $this->registerRouter();
    }
    
    /**
     * Initialisation
     */
    public function initialize(): void
    {
    }
    
    /**
     * Set the default DI
     */
    public function setDI(?DiInterface $di = null): void
    {
        $di ??= $this->isCli()
            ? new FactoryDefault\Cli()
            : new FactoryDefault();
        
        $this->di = $di;
        $this->di->setShared('bootstrap', $this);
        Di::setDefault($this->di);
    }
    
    public function setMode(?string $mode = null): void
    {
        $this->mode = $mode ?? (Php::isCli()
            ? self::MODE_CLI
            : self::MODE_MVC
        );
    }
    
    public function getMode(): string
    {
        return $this->mode;
    }
    
    /**
     * Get the default DI
     */
    public function getDI(): DiInterface
    {
        return $this->di;
    }
    
    /**
     * Set the Config
     */
    public function setConfig(ConfigInterface $config): void
    {
        $this->config = $config;
    }
    
    /**
     * Get the Config
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
    
    /**
     * Set the MVC or CLI Router
     */
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }
    
    /**
     * Get the MVC or CLI Router
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
    
    /**
     * Register Config
     */
    public function registerConfig(): void
    {
        if (!$this->di->has('config')) {
            $configService = new ConfigServiceProvider($this->di);
            $configService->register($this->di);
        }
        $this->config ??= $this->di->get('config');
    }
    
    /**
     * Register Service Providers
     * @throws Exception
     */
    public function registerServices(?array $providers = null): void
    {
        $providers ??= $this->config->pathToArray('providers') ?? [];
        foreach ($providers as $key => $provider) {
            if (!is_string($provider)) {
                throw new Exception('Service Provider `' . $key . '` class name must be a string.', 400);
            }
            if (!class_exists($provider)) {
                throw new Exception('Service Provider `' . $key . '` class  `' . $provider . '` not found.', 404);
            }
            $this->di->register(new $provider($this->di));
        }
    }
    
    /**
     * Register Router
     */
    public function registerRouter(): void
    {
        if (!$this->di->has('router')) {
            $configService = new RouterServiceProvider($this->di);
            $configService->register($this->di);
        }
        $this->router ??= $this->di->get('router');
    }
    
    /**
     * Boot Service Providers
     */
    public function bootServices(): void
    {
        $this->di->get('debug');
    }
    
    /**
     * Register modules
     */
    public function registerModules(AbstractApplication $application = null, ?array $modules = null, ?string $defaultModule = null): void
    {
        $application ??= $this->isMvc()
            ? $this->di->get('application')
            : $this->di->get('console');
        assert($application instanceof AbstractApplication);
        
        $modules ??= $this->config->pathToArray('modules') ?? [];
        $application->registerModules($modules);
        
        $defaultModule ??= $this->config->path('router.defaults.module');
        $application->setDefaultModule($defaultModule);
    }
    
    /**
     * Handle cli or mvc application
     * @throws \Exception
     */
    public function run(): ?string
    {
        $this->fire('beforeRun');
        
        if ($this->isMvc()) {
            
            $application = $this->di->get('application');
            $content = $this->handleApplication($application);
        }
        elseif ($this->isCli()) {
            
            $console = $this->di->get('console');
            $content = $this->handleConsole($console);
        }
        else {
            throw new \Exception('Application or Console not found', 404);
        }
        
        $this->fire('afterRun', $content);
        
        return $content;
    }
    
    /**
     * Handle Console (For CLI only)
     */
    public function handleConsole(Console $console): ?string
    {
        $response = null;
        try {
            ob_start();
            $console->handle($this->getArgs());
            $response = ob_get_clean() ?: null;
        }
        catch (\Zemit\Exception $e) {
            new Cli\ExceptionHandler($e);
        }
        catch (\Exception $exception) {
            new Cli\ExceptionHandler($exception);
        }
        catch (\Throwable $throwable) {
            new Cli\ExceptionHandler($throwable);
        }
        
        return $response;
    }
    
    /**
     * Handle Application
     * @throws \Exception
     */
    public function handleApplication(Application $application): string
    {
        $this->response = $application->handle($_SERVER['REQUEST_URI'] ?? '/') ?: null;
        return $this->response ? $this->response->getContent() : '';
    }
    
    /**
     * Get & format args from the $this->args property
     */
    public function getArgs(): array
    {
        $args = [];
        
        if ($this->isCli()) {
            $argv = array_slice($_SERVER['argv'] ?? [], 1);
            $response = (new Docopt())->handle($this->cliDoc, ['argv' => $argv, 'optionsFirst' => true]);
            foreach ($response as $key => $value) {
                if (!is_null($value) && preg_match('/(<(.*?)>|\-\-(.*))/', $key, $match)) {
                    $key = lcfirst(Helper::camelize(Helper::uncamelize(array_pop($match))));
                    $args[$key] = $value;
                }
            }
        }
        
        return $args;
    }
    
    /**
     * Return true if the bootstrap mode is set to 'cli'
     */
    public function isCli(): bool
    {
        return $this->getMode() === self::MODE_CLI;
    }
    
    /**
     * Return true if the bootstrap mode is set to 'mvc'
     */
    public function isMvc(): bool
    {
        return $this->getMode() === self::MODE_MVC;
    }
    
    /**
     * Alias for the ->isCli() method
     * @deprecated
     */
    public function isConsole(): bool
    {
        return $this->isCli();
    }
    
    /**
     * Alias for the ->isMvc() method
     * @deprecated
     */
    public function isDefault(): bool
    {
        return $this->isMvc();
    }
}
