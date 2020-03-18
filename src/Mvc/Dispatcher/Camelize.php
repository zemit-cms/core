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

use Phalcon\Di\Injectable;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Text;

class Camelize extends Injectable
{
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher) {
        $dispatcher->setActionName(lcfirst(Text::camelize(Text::uncamelize($dispatcher->getActionName()))));
    }
}