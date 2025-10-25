<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Behavior\Skip;

use Phalcon\Events\Event;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Restful;

class SkipSoftDeleteCondition
{
    public function afterConditions(Event $event, Restful $controller): void
    {
        $controller->getConditions()?->remove('softDelete');
    }
}
