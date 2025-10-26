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
    public function setDeletedAt($deletedAt): void;
    public function getDeletedAt(): mixed;
    
    public function setDeletedBy($deletedBy): void;
    public function getDeletedBy(): mixed;
    
    public function setDeletedAs($deletedAs): void;
    public function getDeletedAs(): mixed;
}
