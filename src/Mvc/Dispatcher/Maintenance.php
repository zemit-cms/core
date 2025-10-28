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

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Dispatcher\Exception;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Zemit\Config\ConfigInterface;
use Zemit\Di\Injectable;
use Zemit\Mvc\Dispatcher;

/**
 * Maintenance Dispatcher Plugin
 * Redirect to the maintenance module/controller/action
 */
class Maintenance extends Injectable
{
    public const ?string DEFAULT_MAINTENANCE_MODULE = null;
    public const ?string DEFAULT_MAINTENANCE_CONTROLLER = 'error';
    public const ?string DEFAULT_MAINTENANCE_ACTION = 'maintenance';
    
    /**
     * Executed before dispatching a request.
     *
     * @param Event $event The event object.
     * @param AbstractDispatcher $dispatcher The dispatcher object.
     *
     * @return void
     *
     * @throws Exception If an error happened during the dispatch forwarding to the maintenance route
     */
    public function beforeDispatch(Event $event, AbstractDispatcher $dispatcher): void
    {
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $maintenance = $config->path('app.maintenance', false);
        if ($maintenance) {
            $route = $config->pathToArray('router.maintenance') ?? [];
            $route['module'] ??= self::DEFAULT_MAINTENANCE_MODULE;
            $route['controller'] ??= self::DEFAULT_MAINTENANCE_CONTROLLER;
            $route['action'] ??= self::DEFAULT_MAINTENANCE_ACTION;
            
            if ($dispatcher instanceof Dispatcher) {
                $dispatcher->forward($route, true);
            } else {
                $dispatcher->forward($route);
            }
            
            if ($event->isCancelable()) {
                $event->stop();
            }
        }
    }
}
