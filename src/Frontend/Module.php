<?php

namespace Zemit\Core\Frontend;

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
    /**
     * Module name to register
     * @var string Module name
     */
    public $moduleName = 'Frontend';
    
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
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        //get services
        $this->getServices($di);
        
        // get current instance namespace
        $namespace = Utils::getNamespace($this);
        
        // register the app module controllers first if possible
        if ($namespace !== __NAMESPACE__) {
            $namespaces[$namespace . '\\Controllers'] = $this->config->app->dir->module . '/controllers/';
        }
        
        // register the vendor module controllers
        $namespaces[__NAMESPACE__ . '\\Controllers'] = $this->config->core->dir->base . '/controllers/';
        
        // register namespaces
        $this->loader->registerNamespaces($namespaces, true);
        
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
        
        // dispatcher settings
        $this->dispatcher->setDefaultNamespace('Zemit\\' . $this->moduleName . '\\Controllers');
        
        // view settings
        $this->view->setViewsDir([
            $this->config->app->dir->module . 'views/',
            $this->config->core->dir->base. $this->moduleName . '/Views/',
        ]);
        
        // url settings
        $this->url->setBasePath('/' . Text::uncamelize($this->moduleName) . '/');
        $this->url->setStaticBaseUri('/' . Text::uncamelize($this->moduleName) . '/');
        
        // router settings
        $this->router->setDefaults(array('namespace' => $this->dispatcher->getDefaultNamespace(), 'controller' => 'index', 'action' => 'index'));
        $this->router->notFound(array('controller' => 'errors', 'action' => 'notFound'));
        $this->router->removeExtraSlashes(true);
        
        // save services
        $this->setServices($di);
    }
    
    public function getServices(DiInterface $di) {
        // Config
        $this->config = $this->config ?? $di['config'] ?? new Config();
        $this->config->app->module = mb_strtolower($this->moduleName);
        $this->config->app->dir->module = $this->config->app->dir->modules . strtolower($this->moduleName) . '/';
        $this->loader = $this->loader ?? $di['loader'] ?? new Loader();
        $this->router = $this->router ?? $di['router'] ?? new Router();
        $this->dispatcher = $this->dispatcher ?? $di['dispatcher'] ?? new Dispatcher();
        $this->view = $this->view ?? $di['view'] ?? new View();
        $this->url = $this->url ?? $di['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $di) {
        $di['config'] = $this->config;
        $di['dispatcher'] = $this->dispatcher;
        $di['loader'] = $this->loader;
        $di['router'] = $this->router;
        $di['view'] = $this->view;
        $di['url'] = $this->url;
    }
    
}
