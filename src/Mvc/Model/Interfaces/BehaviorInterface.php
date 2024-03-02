<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Mvc\Model\Interfaces;

use Phalcon\Mvc\Model\BehaviorInterface as PhalconBehaviorInterface;

interface BehaviorInterface
{
    public function getBehavior(string $behaviorName): PhalconBehaviorInterface;
    
    public function setBehavior(string $behaviorName, PhalconBehaviorInterface $behavior): void;
    
    public function hasBehavior(string $behaviorName): bool;
}
