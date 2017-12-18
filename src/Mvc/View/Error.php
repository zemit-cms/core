<?php

namespace Zemit\Core\Mvc\View;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

class Error extends Injectable
{
    public function beforeRenderView(Event $event, ViewInterface $view, $currentView = null) {

    }

    public function notFoundView(Event $event, ViewInterface $view, $currentView = null) {

    }
}