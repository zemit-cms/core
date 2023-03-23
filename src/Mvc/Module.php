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
use Phalcon\Mvc\RouterInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Bootstrap\Config;
use Zemit\Utils;
use Zemit\Url;

/**
 * {@inheritDoc}
 */
class Module implements ModuleDefinitionInterface
{
    public const NAME_FRONTEND = 'frontend';
    public const NAME_ADMIN = 'admin';
    public const NAME_API = 'api';
    public const NAME_CLI = 'cli';
    public const NAME_OAUTH2 = 'oauth2';
    
    public string $name;
    
    public Config $config;
    
    public Dispatcher $dispatcher;
    
    public Loader $loader;
    
    public Router $router;
    
    public View $view;
    
    public Url $url;
    
    /**
     * Registers an autoloader related to the frontend module
     */
    public function registerAutoloaders(DiInterface $container = null): void
    {
        //get services
        $this->getServices($container);
        
        // register namespaces
        $this->loader->registerNamespaces($this->getNamespaces(), true);
        
        // register autoloader
        $this->loader->register();
        
        // save services
        $this->setServices($container);
    }
    
    /**
     * Registers services related to the module
     */
    public function registerServices(DiInterface $container): void
    {
        // get services
        $this->getServices($container);
        
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
        $this->setServices($container);
    }
    
    public function getViewsDir(): array
    {
        return [
            Utils::getDirname($this) . '/Views/',
        ];
    }
    
    public function getNamespaces(): array
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
    
    public function getServices(DiInterface $container = null): void
    {
        $this->config = $this->config ?? $container['config'] ?? new Config();
        $this->config->app->module = mb_strtolower($this->name);
        $this->config->app->dir->module = $this->config->app->dir->modules . $this->name . '/';
        $this->loader = $this->loader ?? $container['loader'] ?? new Loader();
        $this->router = $this->router ?? $container['router'] ?? new Router();
        $this->dispatcher = $this->dispatcher ?? $container['dispatcher'] ?? new Dispatcher();
        $this->view = $this->view ?? $container['view'] ?? new View();
        $this->url = $this->url ?? $container['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $container = null): void
    {
        $container['config'] = $this->config;
        $container['dispatcher'] = $this->dispatcher;
        $container['loader'] = $this->loader;
        $container['router'] = $this->router;
        $container['view'] = $this->view;
        $container['url'] = $this->url;
    }
}
