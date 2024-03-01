<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

interface SoftDeleteInterface
{
    public function initializeSoftDelete(?array $options = null): void;
    
    public function setSoftDeleteBehavior(Behavior\SoftDelete $softDeleteBehavior): void;
    
    public function getSoftDeleteBehavior(): Behavior\SoftDelete;

    public function disableSoftDelete(): void;
    
    public function enableSoftDelete(): void;
    
    public function isDeleted(?string $field = null, ?int $deletedValue = null): bool;
    
    public function restore(?string $field = null, ?int $notDeletedValue = null): bool;
}
