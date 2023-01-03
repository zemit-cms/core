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
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Router
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'router';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $eventsManager = $di->get('eventsManager');
            
            /** @var Bootstrap\Config $config */
            $config = $di->get('config');
            
            /** @var Bootstrap $bootstrap */
            $bootstrap = $di->get('bootstrap');
            
            /**
             * Router
             */
            $router = $bootstrap->isConsole()
                ? new CliRouter(true)
                : new Router(true, $bootstrap->application);
    
            $defaults = $config->path($bootstrap->isConsole()? 'router.cli': 'router.defaults');
            $router->setDefaults($defaults? $defaults->toArray() : []);
            $router->setEventsManager($eventsManager);
            $router->setDI($di);
            
            return $router;
        });
    }
}
