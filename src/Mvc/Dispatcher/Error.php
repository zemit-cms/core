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

use \Exception;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Zemit\Mvc\Dispatcher;

/**
 * Class Error
 * @package Zemit\Mvc\Dispatcher
 */
class Error extends Injectable
{
    /**
     * Error -> not-found - 404
     */
    const DEFAULT_404_MODULE = null;
    const DEFAULT_404_CONTROLLER = 'error';
    const DEFAULT_404_ACTION = 'notFound';
    
    /**
     * Error -> fatal - 500
     */
    const DEFAULT_500_MODULE = null;
    const DEFAULT_500_CONTROLLER = 'error';
    const DEFAULT_500_ACTION = 'fatal';
    
    /**
     * Dispatcher Error Plugin
     * - Handling 404 & 500 for now
     * @todo improve to handle all possible error codes instead of words
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param Exception $exception
     *
     * @return bool
     * @throws Exception
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception) {
        switch ($exception->getCode()) {
            case DispatchException::EXCEPTION_NO_DI:
                // no di, calm down for now and see what happens after
                // maybe if module can't be found
                // @todo why?
                break;
            case DispatchException::EXCEPTION_HANDLER_NOT_FOUND:
            case DispatchException::EXCEPTION_ACTION_NOT_FOUND:
                $route = $this->config->router->notFound->toArray() ?? [];
                $route['module'] ??= self::DEFAULT_404_MODULE;
                $route['controller'] ??= self::DEFAULT_404_CONTROLLER;
                $route['action'] ??= self::DEFAULT_404_ACTION;
                $route['params']['exception'] = $exception;
                $dispatcher->forward($route, true);
                return false;
                break;
            default:
                // Everything else, if debug is false, forward forward to fatal error 500
                if (!$this->config->app->debug && !$this->config->debug->enable) {
                    $route = $this->config->router->error->toArray() ?? [];
                    $route['module'] ??= self::DEFAULT_500_MODULE;
                    $route['controller'] ??= self::DEFAULT_500_CONTROLLER;
                    $route['action'] ??= self::DEFAULT_500_ACTION;
                    $route['params']['exception'] = $exception;
                    $dispatcher->forward($route, true);
                    return false;
                } else {
                    throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
                }
                break;
        }
    }
}
