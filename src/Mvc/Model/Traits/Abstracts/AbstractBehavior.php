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

namespace PhalconKit\Mvc\Model\Traits\Abstracts;

use Phalcon\Mvc\Model\BehaviorInterface;

trait AbstractBehavior
{
    abstract public function addBehavior(BehaviorInterface $behavior): void;
    
    abstract public function getBehavior(string $behaviorName): ?BehaviorInterface;
    
    abstract public function setBehavior(string $behaviorName, BehaviorInterface $behavior): void;
    
    abstract public function hasBehavior(string $behaviorName): bool;
    
    abstract public function removeBehavior(string $behaviorName): void;
}
