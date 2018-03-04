<?php

namespace Zemit\Core\Mvc\Dispatcher;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Text;

class Module extends Injectable
{
    public function beforeDispatchLoop(Event $event, DispatcherInterface $dispatcher) {
        $module = $this->getDI()->get('config')->modules->{$dispatcher->getModuleName()};
        if (is_array($module) || $module instanceof \Traversable) {
            foreach ($module as $module) {
                if (is_callable($module)) {
                
                }
            }
        }
    }
}