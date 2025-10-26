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

interface UpdateInterface
{
    public function setUpdatedAt(mixed $updatedAt): void;
    public function getUpdatedAt(): mixed;
    
    public function setUpdatedBy(mixed $updatedBy): void;
    public function getUpdatedBy(): mixed;
    
    public function setUpdatedAs(mixed $updatedAs): void;
    public function getUpdatedAs(): mixed;
}
