<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Application;
use Phalcon\Text;
use Zemit\Core\Mvc\Router\ModuleRoute;
use Zemit\Core\Zemit;

class Router extends PhalconRouter
{
    public $defaults = [
        'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ];
    
    public $notFound = [
        'controller' => 'errors',
        'action' => 'notFound'
    ];
    
    public $config;
    
    /**
     * Router constructor.
     */
    public function __construct($defaultRoutes = true, Application $application = null)
    {
        parent::__construct(false);
        if (isset($application)) {
            $this->config = $application->getDI()->get('config');
        }
        $this->defaultRoutes();
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
        $this->mount(new ModuleRoute($this->getDefaults(), true));
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
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key])));
        }
    }
    
    public function camelize($string)
    {
        return lcfirst(Text::camelize(Text::uncamelize($string)));
    }
}
