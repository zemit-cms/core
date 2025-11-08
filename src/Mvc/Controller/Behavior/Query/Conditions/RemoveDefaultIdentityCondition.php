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

namespace PhalconKit\Mvc\Controller\Behavior\Query\Conditions;

use Phalcon\Events\Event;
use PhalconKit\Mvc\Controller\Restful;

class RemoveDefaultIdentityCondition
{
    public function afterInitializeConditions(Event $event, Restful $controller): void
    {
        $controller->getIdentityConditions()?->remove('default');
    }
}
