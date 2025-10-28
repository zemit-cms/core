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

use Zemit\Mvc\Model\Behavior\Position as PositionBehavior;

interface PositionInterface
{
    public function initializePosition(?array $options = null): void;
    
    public function setPositionBehavior(PositionBehavior $positionBehavior): void;
    
    public function getPositionBehavior(): PositionBehavior;
    
    public function reorder(?int $position = null, ?string $positionField = null): bool;
}
