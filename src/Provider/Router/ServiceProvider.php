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
use Zemit\Mvc\Router\Identity;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Routing\ServiceProvider
 *
 * @package Zemit\Provider\Routing
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
        $di->setShared($this->getName(), function() use ($di) {
            $eventsManager = $di->get('eventsManager');
            $config = $di->get('config')->router;
            
            /** @var Bootstrap $bootstrap */
            $bootstrap = $di->get('bootstrap');
    
            /**
             * Identity
             */
            $auth = new Identity();
            $auth->setDI($di);
            $eventsManager->attach('dispatch', $auth);
    
            /**
             * Router
             */
            $router = $bootstrap->isConsole()? new \Phalcon\Cli\Router(true) :  new Router(true, $bootstrap->application);
            $router->setDI($di);
            $router->setDefaultModule($config->defaults->module);
            $router->setDefaultNamespace($config->defaults->namespace);
            $router->setEventsManager($eventsManager);
            
            return $router;
        });
    }
}
