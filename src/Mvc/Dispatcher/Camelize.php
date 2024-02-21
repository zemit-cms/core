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

use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Zemit\Di\Injectable;
use Zemit\Support\Helper;

class Camelize extends Injectable
{
    /**
     * Automagically camelize the action name
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher): void
    {
        if ($dispatcher instanceof MvcDispatcher) {
            $dispatcher->setControllerName(
                ucfirst(
                    Helper::camelize(
                        Helper::uncamelize(
                            $dispatcher->getControllerName()
                        )
                    )
                )
            );
        }
        
        $dispatcher->setActionName(
            lcfirst(
                Helper::camelize(
                    Helper::uncamelize(
                        $dispatcher->getActionName()
                    )
                )
            )
        );
    }
}
