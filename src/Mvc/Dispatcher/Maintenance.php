<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Acl\Resource;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Zemit\Mvc\Dispatcher;

/**
 * Maintenance Dispatcher Plugin
 *
 * Redirect to the maintenance module/controller/action
 */
class Maintenance extends Injectable
{
    const DEFAULT_MAINTENANCE_MODULE = null;
    const DEFAULT_MAINTENANCE_CONTROLLER = 'error';
    const DEFAULT_MAINTENANCE_ACTION = 'maintenance';
    
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @throws \Exception Throw a maintenance in progress exception 503 if not maintenance router provided
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $maintenance = $this->config->app->maintenance ?? false;
        if ($maintenance) {
            if ($this->config->router->maintenance) {
                $route = $this->config->router->maintenance->toArray() ?? [];
                $route['module'] ??= self::DEFAULT_MAINTENANCE_MODULE;
                $route['controller'] ??= self::DEFAULT_MAINTENANCE_CONTROLLER;
                $route['action'] ??= self::DEFAULT_MAINTENANCE_ACTION;
                $dispatcher->forward($route, true);
            } else {
                throw new \Exception('Maintenance mode is activated', 503);
            }
        }
    }
    
    
}
