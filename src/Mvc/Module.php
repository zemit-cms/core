<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\RouterInterface;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Text;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Router;
use Zemit\Utils;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Module implements ModuleDefinitionInterface
{
    const NAME_FRONTEND = 'frontend';
    const NAME_BACKEND = 'backend';
    const NAME_API = 'api';
    const NAME_CLI = 'cli';
    const NAME_OAUTH2 = 'oauth2';
    
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
            $this->config->core->dir->base . 'Modules/' . Text::camelize($this->name) . '/Views/',
        ]);
        
        // url settings
        $this->url->setBasePath('/' . $this->name . '/');
        $this->url->setStaticBaseUri('/' . $this->name . '/');
    
        $this->router->setDefaults([
            'namespace' => $this->dispatcher->getDefaultNamespace(),
            'module' => $this->name,
            'controller' => 'index',
            'action' => 'index'
        ]);
        
        // router settings
        if ($this->router instanceof RouterInterface) {
            $this->router->notFound([
                'controller' => 'error',
                'action' => 'notFound'
            ]);
            
            $this->router->removeExtraSlashes(true);
        }
        
        // save services
        $this->setServices($di);
    }
    
    public function getNamespaces()
    {
        $namespaces = [];
    
        // Caller namespace
        $namespace = Utils::getNamespace($this);
        
        // register the vendor module controllers
        $namespaces[$namespace . '\\Controllers'] = $this->config->core->dir->modules . '/' . Text::camelize($this->name) . '/Controllers/';
        $namespaces[$namespace . '\\Models'] = $this->config->core->dir->modules . '/' . Text::camelize($this->name) . '/Models/';
        $namespaces['Zemit\\Models'] = $this->config->core->dir->base . '/Models/';
        return $namespaces;
    }
    
    public function getServices(DiInterface $di = null)
    {
        // Config
        $this->config = $this->config ?? $di['config'] ?? new Config();
        $this->config->app->module = mb_strtolower($this->name);
        $this->config->app->dir->module = $this->config->app->dir->modules . $this->name . '/';
        $this->loader = $this->loader ?? $di['loader'] ?? new Loader();
        $this->router = $this->router ?? $di['router'] ?? new Router();
        $this->dispatcher = $this->dispatcher ?? $di['dispatcher'] ?? new Dispatcher();
        $this->view = $this->view ?? $di['view'] ?? new View();
        $this->url = $this->url ?? $di['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $di = null)
    {
        $di['config'] = $this->config;
        $di['dispatcher'] = $this->dispatcher;
        $di['loader'] = $this->loader;
        $di['router'] = $this->router;
        $di['view'] = $this->view;
        $di['url'] = $this->url;
    }
}
