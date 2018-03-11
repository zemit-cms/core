<?php
namespace Zemit\Core;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Zemit\Core\Mvc\Application;
use Phalcon\Cli\Console;

use Phalcon\Text;
use Zemit\Core\Bootstrap\App;
use Zemit\Core\Bootstrap\Config;
use Zemit\Core\Bootstrap\Services;
use Zemit\Core\Bootstrap\Modules;
use Zemit\Core\Bootstrap\Router;

use Dotenv\Dotenv;
use Docopt;

/**
 * Class Bootstrap
 * Zemit Core's Bootstrap for the MVC Application & CLI Console mode
 *
 * @package Zemit\Core
 */
class Bootstrap
{
    public $mode;
    public $di;
    public $dotenv;
    public $app;
    public $config;
    public $services;
    public $application;
    public $modules;
    public $router;
    public $args;
    public $docopt;
    public $doc = <<<DOC
Zemit Console

Usage:
  zemit <module> <task> <action> [<params> ...]  [--env=<env>] [--debug=<debug>] [--plugin=<plugin>] [--log-file=<file>]
  zemit (-h | --help)
  zemit (-v | --version)
  zemit (-i | --info)
  zemit (-c | --config)

Options:
  -h --help               show this help message
  -v --version            print version number
  -i --info               print environment informations
  -c --config             print the generated config that is used
  -V --verbose            increase verbosity
  -q --quiet              suppress non-error messages
  -f --force              force action even if not safe
  -n --dry-run            perform a trial run with no changes made
  -p --plugins            execute task for all plugins at once
  --ignore-errors         keep executing the task even after errors
  --plugin=<plugin>       plugin to execute the task
  --log-file=<file>       log what we're doing to the specified file [default: private/logs/cli.log]
  --debug=<debug>         Force the debug and ignore debug value from the config [default: false]
  --env=<env>             Force environment to pick the configuration files [default: development]
DOC;
    
    /**
     * Bootstrap constructor.
     * Setup the di, env, app, config, services, applications, modules and then the router
     *
     * @param string $mode Mode for the application 'normal' 'console'
     */
    public function __construct($mode = 'normal')
    {
        $this->mode = $mode;
        $this->di();
        $this->dotenv();
        $this->docopt();
        $this->app();
        $this->config();
        $this->services();
        $this->application();
        $this->modules();
        $this->router();
    }
    
    public function docopt() {
        if ($this->mode === 'console') {
            $this->docopt = new Docopt();
            $this->args = $this->docopt->handle($this->doc);
        }
    }
    
    /**
     * Prepare the DI including itself (Bootstrap) and setup as default DI
     * Also use the cli factory default for console mode
     * @return mixed|FactoryDefault|FactoryDefault\Cli Return a factory default DI
     */
    public function di() {
        // Use the phalcon cli factory default for console mode
        if ($this->mode === 'console') {
            $this->di = new FactoryDefault\Cli();
        }
        else {
            $this->di = new FactoryDefault();
        }
        $this->di->setShared('bootstrap', $this);
        Di::setDefault($this->di);
        return $this->di;
    }
    
    /**
     * @return Dotenv\Dotenv
     */
    public function dotenv() {
        try {
            $this->dotenv = new Dotenv(dirname(__DIR__));
            $this->dotenv->load();
        } catch (\Dotenv\Exception\InvalidPathException $e) {
            // just ignore and run the application anyway
        }
        return $this->dotenv;
    }
    
    /**
     * Instantiate the default app settings
     * @return App
     */
    public function app() {
        $this->app = new App();
        return $this->app;
    }
    
    /**
     * Instantiate the configuration
     * @return Config
     */
    public function config() {
        $this->config = new Config();
        $this->config->mergeEnvConfig();
        $this->config->mode = $this->mode;
        return $this->config;
    }
    
    /**
     * Instantiate the services
     * @return Services
     */
    public function services() {
        $this->services = new Services($this->di, $this->config);
        return $this->services;
    }
    
    public function application() {
        if ($this->mode === 'console') {
            $this->application = new Console($this->di);
        }
        else {
            $this->application = new Application($this->di);
        }
        return $this->application;
    }
    
    public function modules() {
        $this->modules = new Modules($this->application);
        return $this->modules;
    }
    
    public function router() {
        $this->router = new Router(true, $this->application);
        $this->di['router'] = $this->router;
        return $this->router;
    }
    
    public function getArguments() {
        $arguments = [];
        foreach($this->args as $key => $value)
        {
            if (preg_match('/(<(.*?)>|\-\-(.*))/', $key, $match))
            {
                $key = lcfirst(Text::camelize(Text::uncamelize(array_pop($match))));
                $arguments[$key] = $value;
            }
        }
        return $arguments;
    }
    
    public function run() {
        // cli console mode, get the arguments from the doctlib
        if ($this->mode === 'console') {
            try {
                $this->application->handle($this->getArguments());
            } catch (\Zemit\Core\Exception $e) {
                new Cli\ExceptionHandler($e);
                // do zemit related stuff here
                exit(1);
            } catch (\Phalcon\Exception $e) {
                new Cli\ExceptionHandler($e);
                // do phalcon related stuff here
                exit(1);
            } catch (\Throwable $throwable) {
                new Cli\ExceptionHandler($throwable);
                exit(1);
            } catch (\Exception $exception) {
                new Cli\ExceptionHandler($exception);
                exit(1);
            }
        }
        else  if (isset($this->application)) {
            // we don't need a try catch here, its handled by the application
            // or the user can wrap it with try catch into the public/index.php instead
            return $this->application->handle()->getContent();
        }
        else {
            throw new \Exception('Application not found', 404);
        }
    }
}