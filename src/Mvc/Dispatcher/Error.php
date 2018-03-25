<?php

namespace Zemit\Core\Mvc\Dispatcher;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Dispatcher;
use \Exception;
use Phalcon\Events\Event;

class Error extends Injectable
{
    public function beforeException(Event $event, DispatcherInterface $dispatcher, Exception $exception) {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_NO_DI:
                // no di, calm down for now and see what happens after
                break;
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                // Not found, forward to errors->notFound (404)
                $dispatcher->forward(array(
                    'controller' => 'errors',
                    'action' => 'notFound',
                    'params' => array(
                        'exception' => $exception
                    )
                ));
                return false;
                break;
            default:
                // Everything else, ff debug is false, forward forward to fatal error 500
                if (!$this->config->app->debug) {
                    $dispatcher->forward(array(
                        'controller' => 'errors',
                        'action' => 'fatal',
                        'params' => array(
                            'exception' => $exception
                        )
                    ));
                    return false;
                }
                break;
        }
    }
}