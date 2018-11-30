<?php

namespace Zemit\Core\Cli;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Cli\Dispatcher;
use Phalcon\Cli\Router;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Core\Bootstrap\Config;
use Zemit\Core\Utils;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Module implements ModuleDefinitionInterface
{
    const NAME_CLI = 'Cli';
    
    public $namespace = __NAMESPACE__;
    
    /**
     * Module name to register
     * @var string Module name
     */
    public $name = self::NAME_CLI;
    
    /**
     * @var Config
     */
    public $config;
    
    /**
     * @var Dispatcher
     */
    public $dispatcher;
    
    /**
     * @var Loader
     */
    public $loader;
    
    /**
     * @var Router
     */
    public $router;
    
    
    /**
     * Registers an autoloader related to the frontend module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        //get services
        $this->getServices($di);
        
        // register namespaces
        $this->loader->registerNamespaces($this->getNamespaces(), true);
        
        // register autoloader
        $this->loader->register();
        
        // save services
        $this->setServices($di);
    }
    
    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // get services
        $this->getServices($di);
        
        // Caller namespace
        $namespace = Utils::getNamespace($this);
        
        // dispatcher settings
        $this->dispatcher->setDefaultNamespace($namespace . '\\Tasks');
        $this->dispatcher->setNamespaceName($namespace . '\\Tasks');
        
        // router settings
        $this->router->setDefaults([
            'namespace' => $this->dispatcher->getDefaultNamespace(),
            'module' => strtolower($this->name),
            'controller' => 'help',
            'action' => 'main'
        ]);
        
        // save services
        $this->setServices($di);
    }
    
    public function getNamespaces()
    {
        $namespaces = [];
        
        // Caller namespace
        $namespace = Utils::getNamespace($this);
        
        // register the vendor module controllers
        $namespaces[$namespace . '\\Tasks'] = $this->config->core->dir->base . $this->name . '/Tasks/';
        $namespaces[$namespace . '\\Models'] = $this->config->core->dir->base . $this->name . '/Models/';

        return $namespaces;
    }
    
    public function getServices(DiInterface $di = null)
    {
        // Config
        $this->config = $this->config ?? $di['config'] ?? new Config();
        $this->config->app->module = mb_strtolower($this->name);
        $this->config->app->dir->module = $this->config->app->dir->modules . strtolower($this->name) . '/';
        $this->loader = $this->loader ?? $di['loader'] ?? new Loader();
        $this->router = $this->router ?? $di['router'] ?? new Router();
        $this->dispatcher = $this->dispatcher ?? $di['dispatcher'] ?? new Dispatcher();
    }
    
    public function setServices(DiInterface $di = null)
    {
        $di['config'] = $this->config;
        $di['dispatcher'] = $this->dispatcher;
        $di['loader'] = $this->loader;
        $di['router'] = $this->router;
    }
    
}
