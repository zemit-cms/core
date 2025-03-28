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

use Exception;
use Phalcon\Dispatcher\Exception as DispatchException;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Events\Event;
use Zemit\Di\Injectable;
use Zemit\Mvc\Dispatcher;

class Error extends Injectable
{
    public array $defaultNotFoundRoute = [
        'module' => null,
        'namespace' => null,
        'controller' => 'error',
        'action' => 'notFound',
    ];
    
    public array $defaultErrorRoute = [
        'module' => null,
        'namespace' => null,
        'controller' => 'error',
        'action' => 'fatal',
    ];
    
    public array $defaultUnauthorizedRoute = [
        'module' => null,
        'namespace' => null,
        'controller' => 'error',
        'action' => 'unauthorized',
    ];
    
    /**
     * Forward to 404 or 500 error controller
     * @throws Exception
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception): bool
    {
        // Everything else, if debug is false, forward to fatal error 500
        $appDebug = $this->config->path('app.debug', false);
        $debugEnable = $this->config->path('debug.enable', false);
        $isDebug = $appDebug || $debugEnable;
        
        switch ($exception->getCode()) {
            
            case DispatchException::EXCEPTION_HANDLER_NOT_FOUND:
            case DispatchException::EXCEPTION_ACTION_NOT_FOUND:
                if ($exception instanceof DispatchException) {
                    $route = $this->config->pathToArray('router.notFound') ?? [];
                    $this->appendDefaultToRoute($route, $this->defaultNotFoundRoute);
                    $route['params']['exception'] = $exception;
                    $dispatcher->forward($route, true);
                    return false;
                }
                break;

            case 401:
                if ($exception instanceof ValidatorException) {
                    http_response_code(401);
                    
                    if (!$isDebug) {
                        $route = $this->config->pathToArray('router.unauthorized') ?? [];
                        $this->appendDefaultToRoute($route, $this->defaultUnauthorizedRoute);
                        $route['params']['exception'] = $exception;
                        $dispatcher->forward($route, true);
                        
                        return false;
                    }
                }
                break;
                
            default:
                http_response_code(500);
                
                if (!$isDebug) {
                    $route = $this->config->pathToArray('router.error') ?? [];
                    $this->appendDefaultToRoute($route, $this->defaultErrorRoute);
                    $route['params']['exception'] = $exception;
                    $dispatcher->forward($route, true);
                    return false;
                }
                break;
        }
        
        throw $exception;
    }
    
    public function appendDefaultToRoute(array $route, array $default): array
    {
        $route['module'] ??= $default['module'] ?? null;
        $route['namespace'] ??= $default['namespace'] ?? null;
        $route['controller'] ??= $default['controller'] ?? null;
        $route['action'] ??= $default['action'] ?? null;
        return $route;
    }
}
