<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Ws;

use Phalcon\Autoload\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Bootstrap\Config;
use Zemit\Support\Utils;

class Module implements ModuleDefinitionInterface
{
    public const string NAME_WS = 'ws';
    
    public string $name = self::NAME_WS;
    
    public ?Config $config = null;
    
    public ?Dispatcher $dispatcher = null;
    
    public ?Loader $loader = null;
    
    public ?Router $router = null;
    
    /**
     * Registers an autoloader related to the frontend module
     */
    #[\Override]
    public function registerAutoloaders(?DiInterface $container = null): void
    {
        $this->loader ??= $container['loader'] ?? new Loader();
        $this->loader->setNamespaces($this->getNamespaces(), true);
        $this->loader->register();
    }
    
    /**
     * Registers services related to the module
     */
    #[\Override]
    public function registerServices(DiInterface $container): void
    {
        $this->getServices($container);
        
        assert($this->dispatcher instanceof DispatcherInterface);
        assert($this->router instanceof \Zemit\Router\RouterInterface);
        
        // dispatcher settings
        $defaultNamespace = $this->getDefaultNamespace();
        $this->dispatcher->setDefaultNamespace($defaultNamespace);
        $this->dispatcher->setNamespaceName($defaultNamespace);
        
        // router settings
        $this->router->setDefaults([
            'namespace' => $defaultNamespace,
            'module' => $this->name,
            'task' => 'main',
            'action' => 'listen',
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
        $this->loader = $container['loader'] ?? new Loader();
        $this->config ??= $container['config'] ?? new Config();
        $this->router ??= $container['router'] ?? new Router();
        $this->dispatcher ??= $container['dispatcher'] ?? new Dispatcher();
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
