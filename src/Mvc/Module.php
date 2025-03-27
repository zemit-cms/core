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
use Zemit\Bootstrap\Config;
use Zemit\Di\Injectable;
use Zemit\Support\Utils;

/**
 * {@inheritDoc}
 */
class Module extends Injectable implements ModuleDefinitionInterface
{
    public const string NAME_FRONTEND = 'frontend';
    public const string NAME_ADMIN = 'admin';
    public const string NAME_API = 'api';
    public const string NAME_OAUTH2 = 'oauth2';
    
    public string $name;
    
    public ?Config $config = null;
    
    public ?Dispatcher $dispatcher = null;
    
    public ?Loader $loader = null;
    
    public ?Router $router = null;
    
    public ?View $view = null;
    
    public ?Url $url = null;
    
    /**
     * Registers an autoloader related to the frontend module
     */
    public function registerAutoloaders(?DiInterface $container = null): void
    {
        $this->loader ??= $container['loader'] ?? new Loader();
        assert($this->loader instanceof Loader);
        
        $this->loader->setNamespaces($this->getNamespaces(), true);
        $this->loader->register();
    }
    
    /**
     * Registers services related to the module
     */
    public function registerServices(DiInterface $container): void
    {
        $this->getServices($container);
        
        assert($this->url instanceof Url);
        assert($this->view instanceof View);
        assert($this->router instanceof Router);
        assert($this->dispatcher instanceof Dispatcher);
        
        $defaultNamespace = $this->getDefaultNamespace();
        $this->dispatcher->setDefaultNamespace($defaultNamespace);
        $this->dispatcher->setNamespaceName($defaultNamespace);
        $this->view->setViewsDir($this->getViewsDir());
        
        // url settings
        $this->url->setBasePath($this->url->getBasePath() . '/' . $this->name . '/');
        $this->router->setDefaults([
            'namespace' => $defaultNamespace,
            'module' => $this->name,
            'controller' => 'index',
            'action' => 'index',
        ]);
        
        // router settings
        $this->router->notFound([
            'controller' => 'error',
            'action' => 'notFound',
        ]);
        $this->router->removeExtraSlashes(true);
        
        $this->setServices($container);
    }
    
    public function getServices(?DiInterface $container = null): void
    {
        $this->loader ??= $container['loader'] ?? new Loader();
        $this->config ??= $container['config'] ?? new Config();
        $this->router ??= $container['router'] ?? new Router();
        $this->dispatcher ??= $container['dispatcher'] ?? new Dispatcher();
        $this->view ??= $container['view'] ?? new View();
        $this->url ??= $container['url'] ?? new Url();
    }
    
    public function setServices(DiInterface $container): void
    {
        $container->set('config', $this->config);
        $container->set('dispatcher', $this->dispatcher);
        $container->set('loader', $this->loader);
        $container->set('router', $this->router);
        $container->set('view', $this->view);
        $container->set('url', $this->url);
    }
    
    public function getNamespaces(): array
    {
        // Caller namespace
        $namespace = $this->getNamespace();
        $dirname = $this->getDirname();
        
        // register the vendor module controllers
        $namespaces = [];
        $namespaces[$namespace . '\\Controllers'] = $dirname . '/Controllers/';
        $namespaces[$namespace . '\\Models'] = $dirname . '/Models/';
        
        // add zemit core models
        $corePath = dirname(__DIR__);
        $namespaces['Zemit\\Models'] = $corePath . '/Models/';
        
        return $namespaces;
    }
    
    public function getDefaultNamespace(): string
    {
        return $this->getNamespace() . '\\Controllers';
    }
    
    public function getViewsDir(): array
    {
        return [$this->getDirname() . '/Views/'];
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
