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

//use Phalcon\Debug;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;
use Phalcon\Cli\Router as CliRouter;
use Phalcon\Text;
use Phalcon\Events;


use Zemit\Debug;
use Zemit\Bootstrap\App;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Services;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Router;
use Zemit\Events\EventsAwareTrait;
use Zemit\Mvc\Application;
use Zemit\Cli\Console;

use Dotenv\Dotenv;
use Docopt;
use Zemit\Mvc\Dispatcher\Module;
use Zemit\Providers\ErrorHandler\ServiceProvider;

/**
 * Class Bootstrap
 * Zemit Core's Bootstrap for the MVC Application & CLI Console mode
 *
 * @package Zemit
 */
class Bootstrap
{
    use EventsAwareTrait;
    
    /**
     * Bootstrap mode
     * @var string
     */
    public $mode;
    
    /**
     * Bootstrap console args
     * @var array|object
     */
    public $args;
    
    /**
     * Dependencies
     * @var FactoryDefault
     */
    public $di;
    
    /**
     * @var Dotenv
     */
    public $dotenv;
    
    /**
     * @TODO change this and its purpose
     * @var App
     */
    public $app;
    
    /**
     * @var Config
     */
    public $config;
    
    /**
     * @var Services
     */
    public $services;
    
    /**
     * @var Application|\Phalcon\Cli\Console
     */
    public $application;
    
    /**
     * @var Modules
     */
    public $modules;
    
    /**
     * @var Router
     */
    public $router;
    
    /**
     * @var Debug
     */
    public $debug;
    
    /**
     * @var Response
     */
    public $response;
    
    /**
     * @var Docopt
     */
    public $docopt;
    
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Zemit Console

Usage:
  zemit <module> <task> [<action>] [<params> ...]  [--env=<env>] [--debug=<debug>] [--plugin=<plugin>] [--log-file=<file>]
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
        $this->setEventsManager(new Events\Manager());
        $this->initialize();
        $this->di();
        $this->dotenv();
        $this->args();
        $this->app();
        $this->config();
        $this->debug();
        $this->services();
        $this->application();
        $this->modules();
        $this->router();
    }
    
    public function initialize()
    {
    
    }
    
    /**
     * @TODO redefine docopt to console param or args or something
     */
    public function args()
    {
        if ($this->mode === 'console') {
            $this->fireSet($this->docopt, Docopt::class);
            $this->args = $this->docopt->handle($this->consoleDoc);
        }
    }
    
    /**
     * Prepare the DI including itself (Bootstrap) and setup as default DI
     * Also use the cli factory default for console mode
     * @return mixed|FactoryDefault|FactoryDefault\Cli Return a factory default DI
     */
    public function di()
    {
        // Use the phalcon cli factory default for console mode
        $this->fireSet($this->di, $this->mode === 'console' ?
            FactoryDefault\Cli::class :
            FactoryDefault::class
            , [], function (Bootstrap $bootstrap) {
                $bootstrap->di->setShared('bootstrap', $bootstrap);
//                $bootstrap->di->register(new \Zemit\Providers\EventsManager\ServiceProvider());
                $bootstrap->di->register(new \Zemit\Providers\ErrorHandler\ServiceProvider());
                Di::setDefault($this->di);
            });
        return $this->di;
    }
    
    /**
     * @return \Dotenv\Dotenv
     */
    public function dotenv()
    {
        try {
            $this->fireSet($this->dotenv, Dotenv::class, [dirname(APP_PATH)], function (Bootstrap $bootstrap) {
                $bootstrap->dotenv->load();
            });
        } catch(\Dotenv\Exception\InvalidPathException $e) {
            // just ignore and run the application anyway
        }
        return $this->dotenv;
    }
    
    /**
     * Instantiate the default app settings
     * @return App
     */
    public function app()
    {
        $this->app = new App();
        return $this->app;
    }
    
    /**
     * Phalcon debug listener
     * @return Debug
     */
    public function debug()
    {
//        $this->fireSet($this->debug, Debug::class, [], function (Bootstrap $bootstrap) {
//            if ($bootstrap->config->app->debug) {
//                $bootstrap->debug->listen();
//            }
//        });
//        return $this->debug;
    }
    
    /**
     * Instantiate the configuration
     * @return Config
     */
    public function config()
    {
        $this->fireSet($this->config, Config::class, [], function (Bootstrap $bootstrap) {
            $bootstrap->config->mode = $bootstrap->mode;
            $bootstrap->config->mergeEnvConfig();
        });
        return $this->config;
    }
    
    /**
     * Instantiate the services
     * @return Services
     */
    public function services()
    {
        $this->fireSet($this->services, Services::class, [$this->di, $this->config]);
        return $this->services;
    }
    
    public function application()
    {
        $this->fireSet($this->application,
            $this->mode === 'console' ?
                Console::class :
                Application::class,
            [$this->di]
        );
        return $this->application;
    }
    
    public function modules()
    {
        $this->fireSet($this->modules, Modules::class, [$this->application]);
        return $this->modules;
    }
    
    public function router()
    {
        $this->fireSet($this->router,
            $this->mode === 'console' ?
                CliRouter::class :
                Router::class,
            $this->mode === 'console' ?
                [true] :
                [true, $this->application],
            function (Bootstrap $bootstrap) {
                $bootstrap->di['router'] = $this->router;
            });
        return $this->router;
    }
    
    public function getArguments()
    {
        $arguments = [];
        foreach ($this->args as $key => $value) {
            if (preg_match('/(<(.*?)>|\-\-(.*))/', $key, $match)) {
                $key = lcfirst(Text::camelize(Text::uncamelize(array_pop($match))));
                $arguments[$key] = $value;
            }
        }
        return $arguments;
    }
    
    public function run()
    {
        $this->fire('beforeRun');
        
        // cli console mode, get the arguments from the doctlib
        if ($this->mode === 'console' || $this->application instanceof Console) {
            try {
                $this->application->handle($this->getArguments());
                $this->fire('afterRun');
            } catch(\Zemit\Exception $e) {
                new Cli\ExceptionHandler($e);
                // do zemit related stuff here
                exit(1);
            } catch(\Phalcon\Exception $e) {
                new Cli\ExceptionHandler($e);
                // do phalcon related stuff here
                exit(1);
            } catch(\Exception $exception) {
                new Cli\ExceptionHandler($exception);
                exit(1);
            } catch(\Throwable $throwable) {
                new Cli\ExceptionHandler($throwable);
                exit(1);
            }
        } else if (isset($this->application) && $this->application instanceof \Phalcon\Application) {
            // we don't need a try catch here, its handled by the application
            // or the user can wrap it with try catch into the public/index.php instead
            $this->response = $this->application->handle($_SERVER['REQUEST_URI'] ?? '/');
            $this->fire('afterRun');
            return $this->response->getContent();
        } else {
            throw new \Exception('Application not found', 404);
        }
    }
    
    public function getMode() : string {
        return $this->mode;
    }
}