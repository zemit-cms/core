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
use Phalcon\Dispatcher\Exception as DispatchException;
use Zemit\Di\Injectable;
use Phalcon\Events\Event;
use Zemit\Mvc\Dispatcher;

/**
 * Class Error
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Dispatcher
 */
class Error extends Injectable
{
    /**
     * Error -> not-found - 404
     */
    const DEFAULT_404_MODULE = null;
    const DEFAULT_404_NAMESPACE = null;
    const DEFAULT_404_CONTROLLER = 'error';
    const DEFAULT_404_ACTION = 'notFound';

    /**
     * Error -> fatal - 500
     */
    const DEFAULT_500_MODULE = null;
    const DEFAULT_500_NAMESPACE = null;
    const DEFAULT_500_CONTROLLER = 'error';
    const DEFAULT_500_ACTION = 'fatal';

    /**
     * Dispatcher Error Plugin
     * - Forward to 404 or 500 error controller
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param Exception $exception
     *
     * @return bool
     * @throws Exception
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        switch ($exception->getCode()) {
            case DispatchException::EXCEPTION_HANDLER_NOT_FOUND:
            case DispatchException::EXCEPTION_ACTION_NOT_FOUND:
                if ($exception instanceof \Phalcon\Dispatcher\Exception) {
                    $route = $this->config->router->notFound->toArray() ?? [];
                    $route['module'] ??= self::DEFAULT_404_MODULE;
                    $route['namespace'] ??= self::DEFAULT_404_NAMESPACE;
                    $route['controller'] ??= self::DEFAULT_404_CONTROLLER;
                    $route['action'] ??= self::DEFAULT_404_ACTION;
                    $route['params']['exception'] = $exception;
                    $dispatcher->forward($route, true);
                    return false;
                }
                break;
            default:
                http_response_code(500);
                // Everything else, if debug is false, forward to fatal error 500
                if (!$this->config->app->debug && !$this->config->debug->enable) {
                    $route = $this->config->router->error->toArray() ?? [];
                    $route['module'] ??= self::DEFAULT_500_MODULE;
                    $route['namespace'] ??= self::DEFAULT_500_NAMESPACE;
                    $route['controller'] ??= self::DEFAULT_500_CONTROLLER;
                    $route['action'] ??= self::DEFAULT_500_ACTION;
                    $route['params']['exception'] = $exception;
                    $dispatcher->forward($route, true);
                    return false;
                }
        }
        throw $exception;
    }
}
