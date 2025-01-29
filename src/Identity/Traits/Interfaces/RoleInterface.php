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

namespace Zemit\Identity\Traits\Interfaces;

interface RoleInterface
{
    public function hasRole(?array $roles = null, bool $or = false, bool $inherit = true): bool;
    
    public function has(array|string|null $needles = null, array $haystack = [], bool $or = false): bool;
    
    public function getInheritedRoleList(array $roleIndexList = []): array;
}
