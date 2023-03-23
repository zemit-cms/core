<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Cli\Dispatcher;
use Zemit\Cli\Router;
use Zemit\Bootstrap\Config;
use Zemit\Utils;

/**
 * Class Module
 *
 *
 *
 * @package Zemit\Modules\Cli
 */
class Module implements ModuleDefinitionInterface
{
    
    public const NAME_CLI = 'cli';
    
    
    public string $name = self::NAME_CLI;
    
    
    public Config $config;
    
    
    public Dispatcher $dispatcher;
    
    
    public Loader $loader;
    
    
    public Router $router;
    
    
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
        $this->dispatcher->setDefaultNamespace($namespace . '\\Tasks');
        $this->dispatcher->setNamespaceName($namespace . '\\Tasks');
        
        // router settings
        $this->router->setDefaults([
            'namespace' => $this->dispatcher->getDefaultNamespace(),
            'module' => strtolower($this->name),
            'controller' => 'help',
            'action' => 'main',
        ]);
        
        // save services
        $this->setServices($container);
    }
    
    public function getNamespaces(): array
    {
        $namespaces = [];
        
        // Caller namespace
        $namespace = Utils::getNamespace($this);
        $dirname = Utils::getDirname($this);
        
        // register the vendor module controllers
        $namespaces[$namespace . '\\Tasks'] = $dirname . '/Tasks/';
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
    }
    
    public function setServices(DiInterface $container = null): void
    {
        $container['config'] = $this->config;
        $container['dispatcher'] = $this->dispatcher;
        $container['loader'] = $this->loader;
        $container['router'] = $this->router;
    }
}
