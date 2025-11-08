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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions;

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
