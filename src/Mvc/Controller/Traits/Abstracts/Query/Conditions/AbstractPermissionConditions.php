<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions;

use Phalcon\Support\Collection;

trait AbstractPermissionConditions
{
    abstract public function initializePermissionConditions(): void;
    
    abstract public function setPermissionConditions(?Collection $permissionConditions): void;
    
    abstract public function getPermissionConditions(): ?Collection;
    
    abstract public function defaultPermissionCondition(): array|string|null;
    
    abstract public function getCreatedByColumns(): array;
    
    abstract public function getSuperRoles(): array;
}
