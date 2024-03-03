<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts;

trait AbstractBehavior
{
    abstract public function attachBehavior(string $behavior, string $eventType = 'rest'): void;
    
    abstract public function attachBehaviors(array $behaviors = [], string $eventType = 'rest'): void;
}
