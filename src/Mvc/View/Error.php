<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\View;

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