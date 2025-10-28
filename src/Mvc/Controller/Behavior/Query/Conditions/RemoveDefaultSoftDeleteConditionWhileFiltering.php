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

namespace Zemit\Mvc\Controller\Behavior\Query\Conditions;

use Phalcon\Events\Event;
use Phalcon\Filter\Exception;
use Zemit\Mvc\Controller\Restful;

class RemoveDefaultSoftDeleteConditionWhileFiltering
{
    /**
     * Handles the initialization of conditions after the controller is set up.
     * Removes the default soft delete condition if the specified filtering parameters are present.
     *
     * @param Event $event The event instance triggered during the controller's lifecycle.
     * @param Restful $controller The controller instance being processed, containing methods for managing filters and conditions.
     * @return void
     * @throws Exception
     */
    public function afterInitializeConditions(Event $event, Restful $controller): void
    {
        if ($controller->hasFiltersFieldsParams(['deleted'])) {
            $controller->getSoftDeleteConditions()?->remove('default');
        }
    }
}
