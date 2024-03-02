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

use Zemit\Mvc\Model\Behavior\SoftDelete;

interface SoftDeleteInterface
{
    public function initializeSoftDelete(?array $options = null): void;
    
    public function setSoftDeleteBehavior(SoftDelete $softDeleteBehavior): void;
    
    public function getSoftDeleteBehavior(): SoftDelete;

    public function disableSoftDelete(): void;
    
    public function enableSoftDelete(): void;
    
    public function isDeleted(?string $field = null, ?int $deletedValue = null): bool;
    
    public function restore(?string $field = null, ?int $notDeletedValue = null): bool;
}
