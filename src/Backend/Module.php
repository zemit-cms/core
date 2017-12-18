<?php

namespace Zemit\Core\Backend;

use Zemit\Tag;
use Phalcon\DiInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Module implements ModuleDefinitionInterface {
    
    /**
     * @var Loader
     */
    public $loader;
    
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null) {
        $loader = new Loader();
        $loader->registerNamespaces([
            'Zemit\\Backend\\Controllers' => $di['config']->application->modulesDir . 'backend/controllers/',
        ], true);
        $loader->register();
        $di['loader'] = $loader;
    }
    
    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di) {
        $config = $di['config'];
        
        $di['url']->setBaseUri('/');
        $di['url']->setStaticBaseUri('/');
        
        $di['view'] = function () use ($config) {
            $view = new View();
            $view->setViewsDir(array(
                $config->application->vendorDir . 'zemit-official/cms-core/src/Backend/Views/',
                $config->application->modulesDir . 'Backend/views/',
            ));
            return $view;
        };
        
        $router = $di['router'];
        $router->setDefaults(array('namespace' => 'Zemit\\Backend\\Controllers', 'controller' => 'index', 'action' => 'index'));
        $router->notFound(array('controller' => 'errors', 'action' => 'notFound'));
        $router->removeExtraSlashes(true);
        $di['router'] = $router;
    }
    
}
