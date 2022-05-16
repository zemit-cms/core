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
use Phalcon\Dispatcher\DispatcherInterface;
use Phalcon\Events\Event;

/**
 * Class Module
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Dispatcher
 */
class Module extends Injectable
{
    public function beforeDispatchLoop(Event $event, DispatcherInterface $dispatcher)
    {
        // @todo use module this way instead?
//        $module = $this->getDI()->get('config')->modules->{$dispatcher->getModuleName()};
//        if (is_array($module) || $module instanceof \Traversable) {
//            foreach ($module as $module) {
//                if (is_callable($module)) {
//                }
//            }
//        }
    }

    public function beforeForward(Event $event, DispatcherInterface $dispatcher, array $forward)
    {
        if (!empty($forward['module'])) {
            $dispatcher->setModuleName($forward['module']);
        }
    }
}
