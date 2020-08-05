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
use Phalcon\Text;

/**
 * Class Camelize
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Dispatcher
 */
class Camelize extends Injectable
{
    /**
     * Automagically camelize the action name
     *
     * @see Text::camelize()
     * @see Text::uncamelize()
     *
     * @param Event $event
     * @param AbstractDispatcher $dispatcher
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher)
    {
        $dispatcher->setActionName(
            lcfirst(
                Text::camelize(
                    Text::uncamelize(
                        $dispatcher->getActionName()
                    )
                )
            )
        );
    }
}
