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

use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Exception;
use Zemit\Di\Injectable;
use Zemit\Mvc\Dispatcher;
use Zemit\Config\ConfigInterface;
use Zemit\Exception\HttpException;

/**
 * Maintenance Dispatcher Plugin
 * Redirect to the maintenance module/controller/action
 */
class Maintenance extends Injectable
{
    public const DEFAULT_MAINTENANCE_MODULE = null;
    public const DEFAULT_MAINTENANCE_CONTROLLER = 'error';
    public const DEFAULT_MAINTENANCE_ACTION = 'maintenance';
    
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @throws HttpException Throws a maintenance in progress exception 503 if not maintenance router provided
     * @throws Exception Throws a phalcon exception if the dispatcher fail to dispatch to the maintenance route
     */
    public function beforeDispatch(Event $event, AbstractDispatcher $dispatcher): void
    {
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $maintenance = $config->path('app.maintenance', false);
        if ($maintenance) {
            $route = $config->pathToArray('router.maintenance');
            if ($route) {
                $route['module'] ??= self::DEFAULT_MAINTENANCE_MODULE;
                $route['controller'] ??= self::DEFAULT_MAINTENANCE_CONTROLLER;
                $route['action'] ??= self::DEFAULT_MAINTENANCE_ACTION;
                $dispatcher->forward($route, true);
            }
            else {
                throw new HttpException('Maintenance mode is activated but no maintenance route is defined.', 503);
            }
        }
    }
}
