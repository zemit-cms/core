<?php

declare(strict_types=1);

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

class RemoveDefaultLimit
{
    public function beforeInitializeQuery(Event $event, Restful $controller): void
    {
        $controller->setMaxLimit(-1);
        $controller->setLimit(-1);
    }
}
