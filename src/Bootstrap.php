<?php
namespace Zemit\Core;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

use Zemit\Bootstrap\App;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Services;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Router;

use Dotenv\Dotenv;

// Load environment


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
    
    public function __construct($mode = 'normal')
    {
        $this->mode = $mode;
        $this->di();
        $this->dotenv();
        $this->app();
        $this->config();
        $this->services();
        $this->application();
        $this->modules();
        $this->router();
    }
    
    /**
     * Prepare the DI including itself (Bootstrap) and setup as default DI
     * @return FactoryDefault
     */
    public function di() {
        $this->di = new FactoryDefault();
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
            // Skip
        }
        return $this->dotenv;
    }
    
    public function app() {
        $this->app = new App();
        return $this->app;
    }
    
    public function config() {
        $this->config = new Config();
        $this->config->mergeEnvConfig();
        return $this->config;
    }
    
    public function services() {
        $this->services = new Services($this->di, $this->config);
        return $this->services;
    }
    
    public function application() {
        $this->application = new Application($this->di);
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
    
    public function run() {
        if (isset($this->application)) {
            echo $this->application->handle()->getContent();
        }
        else {
            throw new \Exception('Application not found', 404);
        }
    }
}