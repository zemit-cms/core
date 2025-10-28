<?php

declare(strict_types=1);

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
    public function setCreatedAt(mixed $createdAt): void;
    public function getCreatedAt(): mixed;
    
    public function setCreatedBy(mixed $createdBy): void;
    public function getCreatedBy(): mixed;
    
    public function setCreatedAs(mixed $createdAs): void;
    public function getCreatedAs(): mixed;
}
