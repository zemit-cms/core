<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Dispatcher;

use Phalcon\Di\DiInterface;
use Zemit\Bootstrap;
use Zemit\Config\ConfigInterface;
use Zemit\Cli\Dispatcher as CliDispatcher;
use Zemit\Ws\Dispatcher as WsDispatcher;
use Zemit\Mvc\Dispatcher as MvcDispatcher;
use Zemit\Mvc\Dispatcher\Camelize;
use Zemit\Mvc\Dispatcher\Preflight;
use Zemit\Mvc\Dispatcher\Error;
use Zemit\Mvc\Dispatcher\Rest;
use Zemit\Mvc\Dispatcher\Security;
use Zemit\Mvc\Dispatcher\Maintenance;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'dispatcher';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $eventsManager = $di->get('eventsManager');
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            /**
             * Camelize
             */
//            $camelize = new Camelize();
//            $camelize->setDI($di);
//            $eventsManager->attach('dispatch', $camelize);
            
            /**
             * Cors & Preflight
             */
            $security = new Preflight();
            $security->setDI($di);
            $eventsManager->attach('dispatch', $security);
            
            /**
             * Security
             */
            $security = new Security();
            $security->setDI($di);
            $eventsManager->attach('dispatch', $security);
            
            /**
             * Maintenance
             */
            $maintenance = new Maintenance();
            $maintenance->setDI($di);
            $eventsManager->attach('dispatch', $maintenance);
            
            /**
             * Logger
             */
            $logger = new MvcDispatcher\Logger();
            $logger->setDI($di);
            $eventsManager->attach('dispatch', $logger);
            
            /**
             * Module
             */
            $module = new MvcDispatcher\Module();
            $module->setDI($di);
            $eventsManager->attach('dispatch', $module);
            
            /**
             * CLI Dispatcher
             */
            if ($bootstrap->isCli()) {
                $dispatcher = new CliDispatcher();
            }
            
            elseif ($bootstrap->isWs()) {
                $dispatcher = new WsDispatcher();
            }
            
            /**
             * MVC Dispatcher
             */
            else {
                /**
                 * Error
                 */
                $error = new Error();
                $error->setDI($di);
                $eventsManager->attach('dispatch', $error);
                
                /**
                 * Rest
                 */
                $rest = new Rest();
                $rest->setDI($di);
                $eventsManager->attach('dispatch', $rest);
                
                // MVC Dispatcher
                $dispatcher = new MvcDispatcher();
            }
            
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDI($di);
    
            // Set default namespace
            $routerDefaultNamespace = $config->path('router.defaults.namespace');
            if (!empty($routerDefaultNamespace)) {
                $dispatcher->setDefaultNamespace($routerDefaultNamespace);
            }
            
            return $dispatcher;
        });
    }
}
