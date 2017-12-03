<?php

namespace Zemit\Core\Mvc\Dispatcher;

use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Events\Event;
use Phalcon\Text;

class Camelize
{
    public function beforeDispatchLoop(Event $event, DispatcherInterface $dispatcher) {
        $dispatcher->setActionName(lcfirst(Text::camelize(Text::uncamelize($dispatcher->getActionName()))));
    }
}