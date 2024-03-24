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

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'router';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $config = $bootstrap->getConfig();
            
            $router = $bootstrap->router ?? $bootstrap->isCli()
                ? new CliRouter(true)
                : new Router(true, $config);
            
            $defaults = $config->pathToArray($bootstrap->isCli() ? 'router.cli' : 'router.defaults') ?? [];
            $router->setDefaults($defaults);
            $router->setDI($di);
            
            if ($router instanceof Router) {
                $router->setEventsManager($di->get('eventsManager'));
                $router->setConfig($config);
                $router->baseRoutes();
                $router->hostnamesRoutes();
                $router->modulesRoutes($di->get('application'));
            }
            
            return $router;
        });
    }
}
