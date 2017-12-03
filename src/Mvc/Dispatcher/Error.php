<?php

namespace Omniscient\Mvc\Dispatcher;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Dispatcher;
use \Exception;
use Phalcon\Events\Event;

class Error extends Injectable
{
    public function beforeException(Event $event, DispatcherInterface $dispatcher, Exception $exception) {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                // Page introuvable, forward vers la page d'erreur 404
                $dispatcher->forward(array(
                    'controller' => 'errors',
                    'action' => 'notFound',
                    'params' => array(
                        'exception' => $exception
                    )
                ));
                return false;
        }
    
        // If debug is false, forward forward to fatal error 500
        if (!$this->config->debug) {
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action' => 'fatal',
                'params' => array(
                    'exception' => $exception
                )
            ));
            return false;
        }
    }
}