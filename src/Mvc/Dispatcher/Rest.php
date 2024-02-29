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

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Zemit\Di\Injectable;

/**
 * @todo
 */
class Rest extends Injectable
{
//    public function beforeDispatch(Event $event, Dispatcher $dispatcher): bool
    public function beforeDispatch(): bool
    {
        return true;
    }
}
