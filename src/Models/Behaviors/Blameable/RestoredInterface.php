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

namespace PhalconKit\Models\Behaviors\Blameable;

interface RestoredInterface
{
    public function setRestoredAt(mixed $restoredAt): void;
    public function getRestoredAt(): mixed;
    
    public function setRestoredBy(mixed $restoredBy): void;
    public function getRestoredBy(): mixed;
    
    public function setRestoredAs(mixed $restoredAs): void;
    public function getRestoredAs(): mixed;
}
