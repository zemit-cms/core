<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Interfaces;

interface BehaviorInterface
{
    public function attachBehavior(string $eventClass, ?string $eventType = null, ?int $priority = null): void;
    
    public function attachBehaviors(array $behaviors = [], string $eventType = null, ?int $priority = null): void;
}
