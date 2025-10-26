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

interface CreatedInterface
{
    public function setCreatedAt($createdAt): void;
    public function getCreatedAt(): mixed;
    
    public function setCreatedBy($createdBy): void;
    public function getCreatedBy(): mixed;
    
    public function setCreatedAs($createdAs): void;
    public function getCreatedAs(): mixed;
}
