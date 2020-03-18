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
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Dispatcher;

/**
 * Class Error
 * @package Zemit\Mvc\Dispatcher
 */
class Error extends Injectable
{
    public function beforeException(Event $event, DispatcherInterface $dispatcher, Exception $exception) {
        switch ($exception->getCode()) {
            case Dispatcher\Exception::EXCEPTION_NO_DI:
                // no di, calm down for now and see what happens after
                break;
            case Dispatcher\Exception::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher\Exception::EXCEPTION_ACTION_NOT_FOUND:
                // Not found, forward to errors->notFound (404)
                $dispatcher->forward([
                    'controller' => 'errors',
                    'action' => 'notFound',
                    'params' => [
                        'exception' => $exception
                    ]
                ]);
                return false;
                break;
            default:
                // Everything else, ff debug is false, forward forward to fatal error 500
                if (!$this->config->app->debug) {
                    $dispatcher->forward([
                        'controller' => 'errors',
                        'action' => 'fatal',
                        'params' => [
                            'exception' => $exception
                        ]
                    ]);
                    return false;
                }
                break;
        }
    }
}