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

use PhalconKit\Mvc\Model\Behavior\Position as PositionBehavior;

interface PositionInterface
{
    public function initializePosition(?array $options = null): void;
    
    public function setPositionBehavior(PositionBehavior $positionBehavior): void;
    
    public function getPositionBehavior(): PositionBehavior;
    
    public function reorder(?int $position = null, ?string $positionField = null): bool;
}
