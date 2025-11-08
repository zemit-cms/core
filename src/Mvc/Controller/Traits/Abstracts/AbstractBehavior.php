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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts;

trait AbstractBehavior
{
    abstract public function attachBehavior(string $eventClass, ?string $eventType = null, ?int $priority = null): void;
    
    abstract public function attachBehaviors(array $behaviors = [], ?string $eventType = null, ?int $priority = null): void;
}
