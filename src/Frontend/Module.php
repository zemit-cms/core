<?php

namespace Zemit\Core\Frontend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Zemit\Core\Bootstrap\Config;
use Zemit\Core\Exception;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Module implements ModuleDefinitionInterface
{
    
    /**
     * @var Loader
     */
    public $loader;
    
    /**
     * @var Config
     */
    public $config;
    
    /**
     * Registers an autoloader related to the module
     *
     * @throws \Exception if $this->loader is not an instance of \Phalcon\Loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $this->config = $di['config'] ?? null;
        $this->loader = $di['loader'] ?? null;
        
        // Make sure the loader is an instance of the phalcon loader class
        if (!($this->loader instanceof Loader)) {
            if (empty($this->loader)) {
                $this->loader = new Loader();
            } else {
                throw new Exception("\$this->\$loader must be an instance of Phalcon\\Loader, instance of \"" . get_class($this->loader) . "\" given.");
            }
        }
        
        // Register frontend namespaces
        $this->loader->registerNamespaces([
            'Zemit\\Frontend\\Controllers' => $this->config->application->modulesDir . 'frontend/controllers/',
        ], true);
        
        // Register the loader and inject into the DI
        $this->loader->register();
        $di['loader'] = $this->loader;
    }
    
    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $config = $di['config'];
        
        $di['url']->setBaseUri('/');
        $di['url']->setStaticBaseUri('/backend/');
        
        $di['view'] = function() use ($config) {
            $view = new View();
            $view->setViewsDir(array(
                $config->application->vendorDir . 'zemit-official/cms-core/src/Frontend/Views/',
//                $config->application->moduleDir . 'views/',
            ));
            return $view;
        };
        
        $router = $di['router'];
        $router->setDefaults(array('namespace' => 'Zemit\\Frontend\\Controllers', 'controller' => 'index', 'action' => 'index'));
        $router->notFound(array('controller' => 'errors', 'action' => 'notFound'));
        $router->removeExtraSlashes(true);
        $di['router'] = $router;
    }
    
}
