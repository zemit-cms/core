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
use Phalcon\Http\Response;
use Phalcon\Cli\Router as CliRouter;
use Phalcon\Text;
use Phalcon\Events;

use Zemit\Bootstrap\Prepare;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Services;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Router;
use Zemit\Events\EventsAwareTrait;
use Zemit\Mvc\Application;
use Zemit\Cli\Console;

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
    
    /**
     * Bootstrap modes
     */
    const MODE_CLI = 'console';
    const MODE_DEFAULT = 'default';
    const MODE_CONSOLE = self::MODE_CLI;
    
    /**
     * @deprecated Use MODE_DEFAULT instead
     */
    const MODE_NORMAL = self::MODE_DEFAULT;
    
    /**
     * Ideally, only the config service provider should be added here, then it will load other service from itself
     * You can also add new Service Providers here if it's absolutely required to be loaded earlier before
     * @var array abstract => concrete
     */
    public $providers = [
        Provider\Config\ServiceProvider::class => Provider\Config\ServiceProvider::class,
    ];
    
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
     * @var FactoryDefault|FactoryDefault\Cli
     */
    public $di;
    
    /**
     * @var Dotenv
     */
    public $dotenv;
    
    /**
     * @var Prepare
     */
    public $prepare;
    
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
     * @param string $mode Mode for the application 'default' 'console'
     *
     * @throws Exception
     */
    public function __construct($mode = self::MODE_DEFAULT)
    {
        $this->mode = $mode;
        $this->setEventsManager(new Events\Manager());
        $this->initialize();
        $this->di();
        $this->dotenv();
        $this->args();
        $this->prepare();
        $this->config();
        $this->debug();
        $this->services();
        $this->application();
        $this->modules();
        $this->router();
    }
    
    /**
     * Initialisation
     */
    public function initialize() {}
    
    /**
     * Get args for console
     * @throws Exception
     */
    public function args()
    {
        $this->fireSet($this->docopt, Docopt::class, [], function (Bootstrap $bootstrap) {
            if ($this->isConsole()) {
                $args = $bootstrap->docopt->handle($bootstrap->consoleDoc);
                $bootstrap->args = is_null($bootstrap->args)? $args : array_merge($bootstrap->args, $args);
            }
        });
    }
    
    /**
     * Prepare the DI including itself (Bootstrap) and setup as default DI
     * Also use the cli factory default for console mode
     * @return FactoryDefault|FactoryDefault\Cli Return a factory default DI
     * @throws Exception
     */
    public function di()
    {
        // Use the phalcon cli factory default for console mode
        $this->fireSet($this->di, $this->isConsole() ?
            FactoryDefault\Cli::class :
            FactoryDefault::class
            , [], function (Bootstrap $bootstrap) {
                // Register bootstrap itself
                $this->di->setShared('bootstrap', $bootstrap);
                
                // Register the ServiceProviders
                foreach ($bootstrap->providers as $provider) {
                    $this->di->register(new $provider($this->di));
                }
                
                // force resolving the config service
                if ($this->di->has('config')) {
                    $this->config = $this->di->get('config');
                }
                
                // Set as the default DI
                Di::setDefault($this->di);
            });
        
        return $this->di;
    }
    
    /**
     * @return Dotenv
     * @throws Exception
     */
    public function dotenv()
    {
        try {
            $this->fireSet($this->dotenv, Dotenv::class, [dirname(APP_PATH)], function (Bootstrap $bootstrap) {
                $bootstrap->dotenv->load();
            });
        } catch(\Dotenv\Exception\InvalidPathException|\Dotenv\Exception\InvalidFileException $e) {
            // just ignore and run the application anyway
        }
        return $this->dotenv;
    }
    
    /**
     * @return Prepare
     * @throws Exception
     */
    public function prepare()
    {
        return $this->fireSet($this->prepare, Prepare::class);
    }
    
    /**
     * @return Debug
     * @throws Exception
     */
    public function debug()
    {
        $this->fireSet($this->debug, Debug::class, [], function (Bootstrap $bootstrap) {
            if ($bootstrap->config->app->debug) {
                $bootstrap->debug->listen();
            }
        });
        return $this->debug;
    }
    
    /**
     * Prepare the config service
     * - Fire events (before & after)
     * - Apply current bootstrap mode ('default', 'console')
     * - Merge with current environment config
     * @return Config
     * @throws Exception
     */
    public function config()
    {
        $this->fireSet($this->config, Config::class);
        return $this->config;
    }
    
    /**
     * Prepare procedural services way
     * - Fire events (before & after)
     * - Pass the current Di object as well as the current Config object
     * @return Services
     * @throws Exception
     */
    public function services()
    {
        $this->fireSet($this->services, Services::class, [$this->di, $this->config]);
        return $this->services;
    }
    
    /**
     * Prepare the application
     * - Fire events (before & after)
     * - Pass the current Di object
     * - Depends on the current bootstrap mode ('default', 'console')
     * @return \Phalcon\Cli\Console|Application
     * @throws Exception
     */
    public function application()
    {
        $this->fireSet($this->application,
            $this->isConsole() ?
                Console::class :
                Application::class,
            [$this->di]
        );
        return $this->application;
    }
    
    /**
     * Prepare the application for modules
     * - Fire events (before & after)
     * - Pass the current Application object
     * @return Modules
     * @throws Exception
     */
    public function modules()
    {
        $this->fireSet($this->modules, Modules::class, [$this->application]);
        return $this->modules;
    }
    
    /**
     * Prepare the router
     * - Fire events (before & after router)
     * - Pass the current application for default mode
     * - Depends on the bootstrap mode ('default', 'default')
     * - Force Re-inject router in the bootstrap DI @TODO is it still necessary
     * @return Router
     * @throws Exception
     */
    public function router()
    {
        $this->fireSet($this->router,
            $this->isConsole() ?
                CliRouter::class :
                Router::class,
            $this->isConsole() ?
                [true] :
                [true, $this->application],
            function (Bootstrap $bootstrap) {
                $bootstrap->di['router'] = $this->router;
            });
        return $this->router;
    }
    
    /**
     * Get & format arguments from the $this->args property
     * @return array Key value pair, human readable
     */
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
    
    /**
     * Run Zemit App
     * - Fire events (before run & after run)
     * - Handle both console and default application
     * - Return response string
     * @return string
     * @throws Exception If the application can't be found
     */
    public function run()
    {
        $this->fire('beforeRun');
        
        // cli console mode, get the arguments from the doctlib
        if ($this->isConsole() || $this->application instanceof Console) {
            try {
                ob_start();
                $this->application->handle($this->getArguments());
                $responseString = ob_get_clean();
                $this->fire('afterRun');
                return $responseString;
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
        } else if (isset($this->application) && ($this->application instanceof \Phalcon\Mvc\Application)) {
            // we don't need a try catch here, its handled by the application
            // or the user can wrap it with try catch into the public/index.php instead
            $this->response = $this->application->handle($_SERVER['REQUEST_URI'] ?? '/');
            $this->fire('afterRun');
            return $this->response->getContent();
        } else {
            if (empty($this->application)) {
                throw new \Exception('Application not found', 404);
            }
            else {
                throw new \Exception('Application not supported', 400);
            }
            
        }
    }
    
    /**
     * Return True if the bootstrap mode is set to 'console'
     * @return bool Console mode
     */
    public function isConsole() : bool {
        return $this->getMode() === self::MODE_CONSOLE;
    }
    
    /**
     * Return the raw bootstrap mode, should be either 'console' or 'default'
     * @return string Bootstrap mode
     */
    public function getMode() : string {
        return $this->mode;
    }
}
