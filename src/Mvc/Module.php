<?php

namespace Zemit\Core\Mvc;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Text;
use Zemit\Core\Bootstrap\Config;
use Zemit\Core\Bootstrap\Router;
use Zemit\Core\Utils;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Module implements ModuleDefinitionInterface
{
    const NAME_FRONTEND = 'Frontend';
    const NAME_BACKEND = 'Backend';
    const NAME_API = 'Api';
    
    public $namespace = __NAMESPACE__;
    
    /**
     * Module name to register
     * @var string Module name
     */
    public $name;
    
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
     * @var View
     */
    public $view;
    
    /**
     * @var Url
     */
    public $url;
    
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
        $this->dispatcher->setDefaultNamespace($namespace . '\\Controllers');
        
        // view settings
        $this->view->setViewsDir([
//            $this->config->app->dir->module . 'views/',
            $this->config->core->dir->base . $this->name . '/Views/',
        ]);
        
        // url settings
        $this->url->setBasePath('/' . Text::uncamelize($this->name) . '/');
        $this->url->setStaticBaseUri('/' . Text::uncamelize($this->name) . '/');
        
        // router settings
        $this->router->removeExtraSlashes(true);
        $this->router->setDefaults([
            'namespace' => $this->dispatcher->getDefaultNamespace(),
            'module' => strtolower($this->name),
            'controller' => 'index',
            'action' => 'index'
        ]);
        $this->router->notFound([
            'controller' => 'errors',
            'action' => 'notFound'
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
        $namespaces[$namespace . '\\Controllers'] = $this->config->core->dir->base . $this->name . '/Controllers/';
        $namespaces[$namespace . '\\Models'] = $this->config->core->dir->base . $this->name . '/Models/';
        
        return $namespaces;
    }
    
    public function getServices(DiInterface $di)
    {
        // Config
        $this->config = $this->config ?? $di['config'] ?? new Config();
        $this->config->app->module = mb_strtolower($this->name);
        $this->config->app->dir->module = $this->config->app->dir->modules . strtolower($this->name) . '/';
        $this->loader = $this->loader ?? $di['loader'] ?? new Loader();
        $this->router = $this->router ?? $di['router'] ?? new Router();
        $this->dispatcher = $this->dispatcher ?? $di['dispatcher'] ?? new Dispatcher();
        $this->view = $this->view ?? $di['view'] ?? new View();
        $this->url = $this->url ?? $di['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $di)
    {
        $di['config'] = $this->config;
        $di['dispatcher'] = $this->dispatcher;
        $di['loader'] = $this->loader;
        $di['router'] = $this->router;
        $di['view'] = $this->view;
        $di['url'] = $this->url;
    }
    
}
