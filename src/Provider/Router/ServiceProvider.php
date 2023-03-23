<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Router;

use Phalcon\Di\DiInterface;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Router;
use Zemit\Cli\Router as CliRouter;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 *
 *
 * @package Zemit\Provider\Router
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     */
    protected $serviceName = 'router';
    
    /**
     * {@inheritdoc}
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $router = $bootstrap->router ?? $bootstrap->isConsole()
                ? new CliRouter(true)
                : new Router(true, $bootstrap->config);
            
            if (is_string($router) && class_exists($router)) {
                $router = new $router();
            }
            
            $defaults = $bootstrap->config->path($bootstrap->isConsole() ? 'router.cli' : 'router.defaults');
            $router->setDefaults($defaults->toArray() ?? []);
            $router->setDI($di);
            
            if ($router instanceof Router) {
                $router->setEventsManager($di->get('eventsManager'));
                $router->setConfig($bootstrap->config);
                $router->baseRoutes();
                $router->hostnamesRoutes();
                $router->modulesRoutes($bootstrap->application);
            }
            
            return $router;
        });
    }
}
