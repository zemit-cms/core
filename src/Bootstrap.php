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

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\ResponseInterface;
use Phalcon\Text;
use Phalcon\Events;
use Zemit\Utils\Env;
use Zemit\Bootstrap\Prepare;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Services;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Router;
use Zemit\Events\EventsAwareTrait;
use Zemit\Mvc\Application;
use Zemit\Cli\Console;
use Zemit\Cli\Router as CliRouter;
use Dotenv\Dotenv;
use Docopt;

/**
 * Class Bootstrap
 * Zemit Core's Bootstrap for the MVC Application & CLI Console mode
 *
 * @package Zemit
 */
class Bootstrap
{
    use EventsAwareTrait;
    
    
    public const MODE_CLI = 'cli';
    
    
    public const MODE_MVC = 'mvc';
    
    
    public const MODE_DEFAULT = self::MODE_MVC;
    
    
    public const MODE_CONSOLE = self::MODE_CLI;
    
    
    /**
     * Ideally, only the config service provider should be added here, then it will load other service from itself
     * You can also add new Service Providers here if it's absolutely required to be loaded earlier before
     * @var ?array abstract => concrete
     */
    public array $providers = [
        Provider\Config\ServiceProvider::class => Provider\Config\ServiceProvider::class,
    ];
    
    /**
     * Bootstrap mode
     * @var string
     */
    public string $mode;
    
    /**
     * Bootstrap cli args
     * - This variable is currently filled by `docopt`
     * @var ?array
     */
    public ?array $args;
    
    /**
     * Dependencies
     * @var null|string|FactoryDefault|FactoryDefault\Cli
     */
    public $di;
    
    /**
     * @var null|string|Dotenv
     */
    public $dotenv;
    
    /**
     * @var null|string|Docopt
     */
    public $docopt;
    
    /**
     * @var null|string|Prepare
     */
    public $prepare;
    
    /**
     * @var null|string|Config
     */
    public $config;
    
    /**
     * @var null|string|Services
     */
    public $services;
    
    /**
     * @var null|string|Application
     */
    public $application;
    
    /**
     * @var null|string|\Phalcon\Cli\Console
     */
    public $console;
    
    /**
     * @var null|string|Modules
     */
    public $modules;
    
    /**
     * @var null|string|Router
     */
    public $router;
    
    /**
     * @var null|string|Debug
     */
    public $debug;
    
    /**
     * @var bool|ResponseInterface
     */
    public $response;
    
    /**
     * @var string
     */
    public string $cliDoc = <<<DOC
Zemit CLI

Usage:
  zemit <module> <task> [<action>] [--help | --quiet | --verbose] [--debug] [--format=<format>] [<args>...] [-c <fds>=<value>]
  zemit (-h | --help)
  zemit (-v | --version)
  zemit (-i | --info)

Options:
  -c <key>=<value>       test
  -h --help               show this help message
  -v --version            print version number
  -i --info               print information
  -q --quiet              suppress output
  -V --verbose            increase verbosity
  -d --debug              enable debug mode
  --format=<format>       change output returned value format (json, xml, serialized, raw, dump)

The most commonly used zemit commands are:
   deployment        Populate the database
DOC;
    
    /**
     * Bootstrap constructor.
     * Setup the di, env, app, config, services, applications, modules and then the router
     *
     * @param string $mode Mode for the application 'default' 'cli'
     *
     * @throws \Exception
     */
    public function __construct(string $mode = self::MODE_DEFAULT)
    {
        $this->mode = $mode;
        $this->setEventsManager(new Events\Manager());
        $this->initialize();
        $this->dotenv();
        $this->docopt();
        $this->di();
        $this->prepare();
        $this->register();
        $this->config();
        $this->debug();
        $this->services();
        $this->application();
        $this->console();
        $this->modules();
        $this->router();
    }
    
    /**
     * Initialisation
     */
    public function initialize()
    {
    }
    
    /**
     * Prepare the DI including itself (Bootstrap) and setup as default DI
     * Also use the cli factory default for cli mode
     * @return FactoryDefault|FactoryDefault\Cli Return a factory default DI
     * @throws \Exception
     */
    public function di()
    {
        // Use the phalcon cli factory default for cli mode
        $this->fireSet($this->di, $this->isCli() ?
            FactoryDefault\Cli::class :
            FactoryDefault::class, [], function (Bootstrap $bootstrap) {
            
            // Register bootstrap itself
                $this->di->setShared('bootstrap', $bootstrap);
            
            // Set as the default DI
                Di::setDefault($this->di);
            });
        return $this->di;
    }
    
    /**
     * Reading .env file
     * @return Dotenv
     * @throws \Exception
     */
    public function dotenv()
    {
        return $this->fireSet($this->dotenv, Env::class, [], function (Bootstrap $bootstrap) {
            
            $bootstrap->dotenv = Env::getDotenv();
        });
    }
    
    /**
     * Get arguments from command line interface cli
     * @return Docopt
     * @throws \Exception
     */
    public function docopt()
    {
        return $this->fireSet($this->docopt, Docopt::class, [], function (Bootstrap $bootstrap) {
            
            if ($this->isCli()) {
                $docoptResponse = $bootstrap->docopt->handle($bootstrap->cliDoc, [
                    'argv' => array_slice($_SERVER['argv'], 1),
                    'optionsFirst' => true,
                ]);
                $bootstrap->args = array_merge($bootstrap->args ?? [], $docoptResponse->args);
            }
        });
    }
    
    /**
     * Preparing some native PHP related stuff
     * @return Prepare
     * @throws \Exception
     */
    public function prepare()
    {
        return $this->fireSet($this->prepare, Prepare::class);
    }
    
    /**
     * Registering bootstrap providers
     */
    public function register(array &$providers = null)
    {
        $providers ??= $this->providers;
        foreach ($providers as $key => $provider) {
            if (is_string($provider) && class_exists($provider)) {
                $provider = new $provider($this->di);
                $this->di->register($provider);
                if ($this->di->has($provider->getName())) {
                    $this->providers[$key] = $this->di->get($provider->getName());
                }
            }
        }
        
        return $this->providers;
    }
    
    /**
     * Prepare the config service
     * - Fire events (before & after)
     * - Apply current bootstrap mode ('default', 'cli')
     * - Merge with current environment config
     * @return Config
     * @throws \Exception
     */
    public function config()
    {
        if ($this->di->has('config')) {
            $this->config = $this->di->get('config');
        }
        return $this->fireSet($this->config, Config::class);
    }
    
    /**
     * @return Debug
     * @throws \Exception
     */
    public function debug()
    {
        return $this->fireSet($this->debug, Debug::class, [], function (Bootstrap $bootstrap) {
            
            $config = $bootstrap->config->debug->toArray();
            $debug = $bootstrap->config->app->get('debug') || $config['enable'];
            $bootstrap->prepare->debug($debug);
            
            // @todo review on phalcon5 php8+ because phalcon4 php8+ debug is doing cyclic error
            $cyclicError =
                version_compare(PHP_VERSION, '8.0.0', '>=') &&
                version_compare(\Phalcon\Version::get(), '5.0.0', '<');
            
            if (!$this->isCli() && !$cyclicError) {
                if ($debug) {
                    $bootstrap->debug->listen($config['exception'] ?? true, $config['lowSeverity'] ?? false);
                    $bootstrap->debug->setBlacklist($config['blacklist'] ?? []);
                    $bootstrap->debug->setShowFiles($config['showFiles'] ?? true);
                    $bootstrap->debug->setShowBackTrace($config['showBackTrace'] ?? true);
                    $bootstrap->debug->setShowFileFragment($config['showFileFragment'] ?? true);
                    
                    if (is_string($config['uri'])) {
                        $bootstrap->debug->setUri($config['uri']);
                    }
                }
            }
        });
    }
    
    /**
     * Prepare procedural services way
     * - Fire events (before & after)
     * - Pass the current Di object as well as the current Config object
     * @return Services
     * @throws \Exception
     */
    public function services()
    {
        return $this->fireSet($this->services, Services::class, [$this->di]);
    }
    
    /**
     * Prepare the application
     * - Fire events (before & after)
     * - Pass the current Di object
     * @return Application
     * @throws \Exception
     */
    public function application()
    {
        return $this->fireSet($this->application, Application::class, [$this->di]);
    }
    
    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function console()
    {
        return $this->fireSet($this->console, Console::class, [$this->di]);
    }
    
    /**
     * Prepare the application for modules
     * - Fire events (before & after)
     * - Pass the current Application object
     * @return Modules
     * @throws \Exception
     */
    public function modules()
    {
        $modules = $this->config->modules->toArray();
        $defaultModule = $this->config->path('router.defaults.module');
        
        return $this->fireSet($this->modules, Modules::class, [$this->isMvc() ? $this->application : $this->console, $modules, $defaultModule]);
    }
    
    /**
     * Prepare the router
     * @return Router
     * @throws \Exception
     */
    public function router()
    {
        if ($this->di->has('router')) {
            $this->router = $this->di->get('router');
        }
        
        return $this->isCli() ?
            $this->fireSet($this->router, CliRouter::class, [true]) :
            $this->fireSet($this->router, Router::class, [true, $this->config]);
    }
    
    /**
     * Run the application
     * - Fire events (before run & after run)
     * - Handle both console and default application
     * - Return response string
     * @return false|string|null
     * @throws \Exception
     */
    public function run()
    {
        $this->fire('beforeRun');
        if ($this->isMvc() && isset($this->application)) {
            
            $content = $this->handleApplication($this->application);
        }
        elseif ($this->isCli() && isset($this->console)) {
            
            $content = $this->handleConsole($this->console);
        }
        else {
            throw new \Exception('Application or Console not found', 404);
        }
        
        $this->fire('afterRun', $content);
        return $content;
    }
    
    /**
     * @param Console $console
     * @return false|string|null
     */
    public function handleConsole(Console $console)
    {
        $response = null;
        try {
            ob_start();
            $console->handle($this->getArguments());
            $response = ob_get_clean();
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
     * @param Application $application
     * @return string
     * @throws \Exception
     */
    public function handleApplication(Application $application): string
    {
        $this->response = $application->handle($_SERVER['REQUEST_URI'] ?? '/');
        return $this->response ? $this->response->getContent() : '';
    }
    
    /**
     * Get & format arguments from the $this->args property
     * @return array Key value pair, human-readable
     */
    public function getArguments(): array
    {
        $arguments = [];
        if (!empty($this->args)) {
            foreach ($this->args as $key => $value) {
                if (preg_match('/(<(.*?)>|\-\-(.*))/', $key, $match)) {
                    $key = lcfirst(Text::camelize(Text::uncamelize(array_pop($match))));
                    $arguments[$key] = $value;
                }
            }
        }
        return $arguments;
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
    
    /**
     * Return the current mode
     */
    public function getMode(): string
    {
        return $this->mode;
    }
}
