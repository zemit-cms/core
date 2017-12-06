<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Application;
use Phalcon\Text;

class Router extends PhalconRouter
{
    public $defaults = [
        'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ];
    
    public $notFound = [
        'controller' => 'error',
        'action' => 'notFound'
    ];
    
    public $config;
    
    /**
     * Router constructor.
     */
    public function __construct($defaultRoutes = true, Application $application = null)
    {
        parent::__construct($defaultRoutes);
        if (isset($application)) {
            $this->config = $application->getDI()->get('config');
        }
        $this->defaultRoutes();
        $this->frontendRoutes();
        if (isset($application)) {
            $this->modulesRoutes($application);
        }
    }
    
    /**
     * Default routes
     * - Default namespace
     * - Default controller
     * - Default action
     * - Default notFound
     * - No module (not yet well supported)
     */
    public function defaultRoutes()
    {
        $this->removeExtraSlashes(true);
        $this->setDefaults($this->config->router->defaults->toArray()?: $this->defaults);
        $this->notFound($this->config->router->notFound->toArray()?: $this->notFound);
    }
    
    public function frontendRoutes() {
        $defaults = $this->getDefaults();
        
        $this->add('/:params', array(
            'controller' => $defaults['controller'],
            'action' => $defaults['action'],
            'params' => 1
        ))->setName('default');
    
        $this->add('/:controller/:params', array(
            'controller' => 1,
            'action' => $defaults['action'],
            'params' => 2
        ))->setName('controller');
    
        $this->add('/:controller/([a-zA-Z0-9\_\-]+)/:params', array(
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ))->setName('controller-action');
//            ->convert('action', function($action) {
//                return $this->camelize($action);
//            })
//            ->convert('controller', function($controller) {
//                return $this->camelize($controller);
//            });
    }
    
    /**
     * Defines our frontend routes
     * /controller/action/params
     */
    public function modulesRoutes(Application $application)
    {
        $defaults = $this->getDefaults();
        
        foreach ($application->getModules() as $key => $module) {
            
            $namespace = str_replace('Module', 'Controllers', $module['className']);
            
            $this->add('/' . $key . '/:params', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => $defaults['controller'],
                'action' => $defaults['action'],
                'params' => 1
            ))->setName($key);
            
            $this->add('/' . $key . '/:controller/:params', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 1,
                'action' => $defaults['action'],
                'params' => 2
            ))->setName($key . '-controller');
//                ->convert('controller', function($controller) {
//                    return $this->camelize($controller);
//                });
            
            $this->add('/' . $key . '/:controller/([a-zA-Z0-9\_\-]+)/:params', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 1,
                'action' => 2,
                'params' => 3
            ))->setName($key . '-controller-action');
//                ->convert('action', function($action) {
//                    return $this->camelize($action);
//                })
//                ->convert('controller', function($controller) {
//                    return $this->camelize($controller);
//                });
            
            $this->add('/' . $key . '/:controller/:int', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 1,
                'id' => 2,
            ))->setName($key . '-controller-int');
        }
    }
    
    public function camelize($string)
    {
        return lcfirst(Text::camelize(Text::uncamelize($string)));
    }
}
