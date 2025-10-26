<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Behaviors\Blameable;

interface RestoredInterface
{
    public function setRestoredAt($restoredAt): void;
    public function getRestoredAt(): mixed;
    
    public function setRestoredBy($restoredBy): void;
    public function getRestoredBy(): mixed;
    
    public function setRestoredAs($restoredAs): void;
    public function getRestoredAs(): mixed;
}
