<?php

namespace Zemit\Core\Frontend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Text;
use Zemit\Core\Bootstrap\Config;
use Zemit\Core\Bootstrap\Router;

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
        
        // register namespaces
        $this->loader->registerNamespaces([
            'Zemit\\'.$this->moduleName.'\\Controllers' => $this->config->application->moduleDir . '/controllers/',
        ], true);
        
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
        
        // view settings
        $this->view = new View();
        $this->view->setViewsDir([
            $this->config->application->vendorDir . 'zemit-official/cms-core/src/' . $this->config->application->moduleName . '/Views/',
            $this->config->application->moduleDir . 'views/',
        ]);
        
        // url settings
        $this->url->setBasePath('/' . Text::uncamelize($this->moduleName) . '/');
        $this->url->setStaticBaseUri('/' . Text::uncamelize($this->moduleName) . '/');
        
        // router settings
        $this->router->setDefaults(array('namespace' => 'Zemit\\' . $this->config->application->moduleName . '\\Controllers', 'controller' => 'index', 'action' => 'index'));
        $this->router->notFound(array('controller' => 'errors', 'action' => 'notFound'));
        $this->router->removeExtraSlashes(true);
        
        // save services
        $this->setServices($di);
    }
    
    public function getServices(DiInterface $di) {
        // Config
        $this->config = $this->config ?? $di['config'] ?? new Config();
        $this->config->application->moduleName = $this->moduleName;
        $this->config->application->moduleDir = $this->config->application->modulesDir . $this->moduleName . '/';
        $this->loader = $this->loader ?? $di['loader'] ?? new Loader();
        $this->router = $this->router ?? $di['router'] ?? new Router();
        $this->view = $this->view ?? $di['view'] ?? new View();
        $this->url = $this->url ?? $di['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $di) {
        $di['config'] = $this->config;
        $di['loader'] = $this->loader;
        $di['router'] = $this->router;
        $di['view'] = $this->view;
        $di['url'] = $this->url;
    }
    
}
