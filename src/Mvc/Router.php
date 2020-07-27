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

use Zemit\Bootstrap\Config;
use Zemit\Mvc\Router\ModuleRoute;

/**
 * Class Router
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
class Router extends \Phalcon\Mvc\Router
{
    /**
     * @var Config
     */
    public $config;
    
    /**
     * Router constructor.
     */
    public function __construct($defaultRoutes = true, $application = null)
    {
        parent::__construct(false);
        if (isset($application)) {
            $this->config = $application->getDI()->get('config');
        }
        if ($defaultRoutes) {
            $this->defaultRoutes();
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
        $this->mount(new ModuleRoute($this->getDefaults(), true, true));
    }
    
    /**
     * Defines our frontend routes
     * /controller/action/params
     */
    public function modulesRoutes($application)
    {
        $defaults = $this->getDefaults();
        foreach ($application->getModules() as $key => $module) {
            if (!isset($module['className'])) {
                throw new \InvalidArgumentException('Module parameter "className" must be a string under "' . $key . '"');
            }
            $namespace = rtrim($module['className'], 'Module') . 'Controllers';
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key])));
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key]), false, true));
        }
    }
    
    /**
     * Router toArray
     * @return array
     */
    public function toArray() {
        $mathedRoute = $this->getMatchedRoute();
        return [
            'namespace' => $this->getNamespaceName(),
            'module' => $this->getModuleName(),
            'controller' => $this->getControllerName(),
            'action' => $this->getActionName(),
            'params' => $this->getParams(),
            'defaults' => $this->getDefaults(),
            'matches' => $this->getMatches(),
            'matched' => [
                'id' => $mathedRoute->getRouteId(),
                'name' => $mathedRoute->getName(),
                'hostname' => $mathedRoute->getHostname(),
                'paths' => $mathedRoute->getPaths(),
                'pattern' => $mathedRoute->getPattern(),
                'httpMethod' => $mathedRoute->getHttpMethods(),
                'reversedPaths' => $mathedRoute->getReversedPaths(),
            ],
        ];
    }
}
