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

interface DeletedInterface
{
    public function setDeletedAt(mixed $deletedAt): void;
    public function getDeletedAt(): mixed;
    
    public function setDeletedBy(mixed $deletedBy): void;
    public function getDeletedBy(): mixed;
    
    public function setDeletedAs(mixed $deletedAs): void;
    public function getDeletedAs(): mixed;
}
