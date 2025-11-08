<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Dispatcher;

use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use PhalconKit\Di\Injectable;
use PhalconKit\Support\Helper;

class Camelize extends Injectable
{
    /**
     * Automagically camelize the action name
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher): void
    {
        if ($event->getType() === 'beforeDispatchLoop') {
            if ($dispatcher instanceof MvcDispatcher) {
                $dispatcher->setControllerName(
                    ucfirst(
                        $this->helper->camelize(
                            $this->helper->uncamelize(
                                $dispatcher->getControllerName()
                            )
                        )
                    )
                );
            }
            
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
}
