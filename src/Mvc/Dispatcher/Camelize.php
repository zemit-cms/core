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

use Zemit\Di\Injectable;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;

class Camelize extends Injectable
{
    /**
     * Automagically camelize the action name
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher): void
    {
        $dispatcher->setActionName(
            lcfirst(
                $this->helper->camelize(
                    $this->helper->uncamelize(
                        $dispatcher->getActionName()
                    )
                )
            )
        );
    }
}
