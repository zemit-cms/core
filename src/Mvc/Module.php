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

use Phalcon\Autoload\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\RouterInterface;
use Phalcon\Mvc\View;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Router;
use Zemit\Utils;

/**
 * Class Module
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc
 */
class Module implements ModuleDefinitionInterface
{
    const NAME_FRONTEND = 'frontend';
    const NAME_ADMIN = 'admin';
    const NAME_API = 'api';
    const NAME_CLI = 'cli';
    const NAME_OAUTH2 = 'oauth2';
    
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
        $this->loader->setNamespaces($this->getNamespaces(), true);
        
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
        $this->view->setViewsDir($this->getViewsDir());
        
        // url settings
        $this->url->setBasePath('/' . $this->name . '/');
        $this->url->setStaticBaseUri('/' . $this->name . '/');
        
        $this->router->setDefaults([
            'namespace' => $this->dispatcher->getDefaultNamespace(),
            'module' => $this->name,
            'controller' => 'index',
            'action' => 'index',
        ]);
        
        // router settings
        if ($this->router instanceof RouterInterface) {
            $this->router->notFound([
                'controller' => 'error',
                'action' => 'notFound',
            ]);
            
            $this->router->removeExtraSlashes(true);
        }
        
        // save services
        $this->setServices($di);
    }
    
    public function getViewsDir()
    {
        return [
            Utils::getDirname(get_class($this)) . '/Views/',
        ];
    }
    
    public function getNamespaces()
    {
        $namespaces = [];
        
        // Caller namespace
        $namespace = Utils::getNamespace($this);
        $dirname = Utils::getDirname($this);
        
        // register the vendor module controllers
        $namespaces[$namespace . '\\Controllers'] = $dirname . '/Controllers/';
        $namespaces[$namespace . '\\Models'] = $dirname . '/Models/';
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
