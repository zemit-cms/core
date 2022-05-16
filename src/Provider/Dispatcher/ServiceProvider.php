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

use Phalcon\Di\DiInterface;

use Zemit\Cli\Dispatcher as CliDispatcher;
use Zemit\Mvc\Dispatcher as MvcDispatcher;
use Zemit\Mvc\Dispatcher\Camelize;
use Zemit\Mvc\Dispatcher\Error;
use Zemit\Mvc\Dispatcher\Rest;
use Zemit\Mvc\Dispatcher\Security;
use Zemit\Mvc\Dispatcher\Maintenance;
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
        $di->setShared($this->getName(), function () use ($di) {
            $eventsManager = $di->get('eventsManager');
            $config = $di->get('config');
            
            /**
             * Camelize
             */
//            $camelize = new Camelize();
//            $camelize->setDI($di);
//            $eventsManager->attach('dispatch', $camelize);
            
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
            
            // CLI Dispatcher
            if (isset($config->mode) && $config->mode === 'console') {
                $dispatcher = new CliDispatcher();
            }
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
            $dispatcher->setDefaultNamespace($config->router->defaults->namespace);
            $dispatcher->setDI($di);
            
            return $dispatcher;
        });
    }
}
