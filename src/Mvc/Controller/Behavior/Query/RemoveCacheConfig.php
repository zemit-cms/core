<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Behavior\Query;

use Phalcon\Events\Event;
use Zemit\Mvc\Controller\Restful;

class RemoveCacheConfig
{
    public function afterInitializeCacheConfig(Event $event, Restful $controller): void
    {
        $controller->getCacheConfig()?->clear();
    }
}
