<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Cli;

use Phalcon\Autoload\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Bootstrap\Config;
use Zemit\Support\Utils;

class Module implements ModuleDefinitionInterface
{
    public const NAME_CLI = 'cli';
    
    public string $name;
    
    public Config $config;
    
    public Dispatcher $dispatcher;
    
    public Loader $loader;
    
    public Router $router;
    
    /**
     * Registers an autoloader related to the frontend module
     */
    public function registerAutoloaders(?DiInterface $container = null): void
    {
        $this->getServices($container);
        $this->loader->setNamespaces($this->getNamespaces(), true);
        $this->loader->register();
    }
    
    /**
     * Registers services related to the module
     */
    public function registerServices(DiInterface $container): void
    {
        $this->getServices($container);
        
        // dispatcher settings
        $defaultNamespace = $this->getDefaultNamespace();
        $this->dispatcher->setDefaultNamespace($defaultNamespace);
        $this->dispatcher->setNamespaceName($defaultNamespace);
        
        // router settings
        $this->router->setDefaults([
            'namespace' => $defaultNamespace,
            'module' => $this->name,
            'controller' => 'help',
            'action' => 'main',
        ]);
        
        $this->setServices($container);
    }
    
    public function getNamespaces(): array
    {
        $namespaces = [];
        
        // Caller namespace
        $namespace = $this->getNamespace();
        $dirname = $this->getDirname();
        
        // register the vendor module controllers
        $namespaces[$namespace . '\\Tasks'] = $dirname . '/Tasks/';
        $namespaces[$namespace . '\\Models'] = $dirname . '/Models/';
    
        // add zemit core models
        $corePath = dirname(__DIR__);
        $namespaces['Zemit\\Models'] = $corePath . '/Models/';
        
        return $namespaces;
    }
    
    public function getServices(?DiInterface $container = null): void
    {
        $this->config ??= $container['config'] ??= new Config();
        $this->loader ??= $container['loader'] ??= new Loader();
        $this->router ??= $container['router'] ??= new Router();
        $this->dispatcher ??= $container['dispatcher'] ??= new Dispatcher();
    }
    
    public function setServices(DiInterface $container): void
    {
        $container->set('config', $this->config);
        $container->set('dispatcher', $this->dispatcher);
        $container->set('loader', $this->loader);
        $container->set('router', $this->router);
    }
    
    public function getDefaultNamespace(): string
    {
        return $this->getNamespace() . '\\Tasks';
    }
    
    public function getDirname(): string
    {
        return Utils::getDirname($this);
    }
    
    public function getNamespace(): string
    {
        return Utils::getNamespace($this);
    }
}
