<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Dispatcher;

use Phalcon\Cli\Dispatcher as CliDispatcher;
use Phalcon\Di\DiInterface;
use Zemit\Mvc\Dispatcher as MvcDispatcher;
use Zemit\Mvc\Dispatcher\Camelize as DispatchCamelize;
use Zemit\Mvc\Dispatcher\Error as DispatchError;
use Zemit\Mvc\Dispatcher\Rest as DispatchRest;
use Zemit\Mvc\Dispatcher\Security as DispatchSecurity;
use Zemit\Mvc\Dispatcher\Maintenance as DispatchMaintenance;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Dispatcher\ServiceProvider
 *
 * @package Zemit\Provider\Dispatcher
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'dispatcher';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $eventsManager = $di->get('eventsManager');
            $config = $di->get('config');
            
            /**
             * Camelize
             */
            $camelize = new DispatchCamelize();
            $camelize->setDI($di);
            $eventsManager->attach('dispatch', $camelize);
            
            /**
             * Security
             */
            $security = new DispatchSecurity();
            $security->setDI($di);
            $eventsManager->attach('dispatch', $security);
            
            /**
             * Maintenance
             */
            $maintenance = new DispatchMaintenance();
            $maintenance->setDI($di);
            $eventsManager->attach('dispatch', $maintenance);
            
            // CLI Dispatcher
            if (isset($config->mode) && $config->mode === 'console') {
                $dispatcher = new CliDispatcher();
            } else {
                /**
                 * Error
                 */
                $error = new DispatchError();
                $error->setDI($di);
                $eventsManager->attach('dispatch', $error);
    
                /**
                 * Rest
                 */
                $rest = new DispatchRest();
                $rest->setDI($di);
                $eventsManager->attach('dispatch', $rest);
                
                // MVC Dispatcher
                $dispatcher = new MvcDispatcher();
            }
            
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace($config->router->defaults->namespace);
            $dispatcher->setDI($di);
            
            return $dispatcher;
        });
    }
}
