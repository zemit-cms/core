<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Mvc\Model\Interfaces;

use Phalcon\Mvc\Model\BehaviorInterface as PhalconBehaviorInterface;

interface BehaviorInterface
{
    public function addBehavior(PhalconBehaviorInterface $behavior): void;
    
    public function getBehavior(string $behaviorName): ?PhalconBehaviorInterface;
    
    public function setBehavior(string $behaviorName, PhalconBehaviorInterface $behavior): void;
    
    public function hasBehavior(string $behaviorName): bool;
    
    public function removeBehavior(string $behaviorName): void;
}
