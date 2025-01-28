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

namespace Zemit\Identity\Traits\Abstracts;

use Zemit\Models\Interfaces\UserInterface;

trait AbstractUser
{
    abstract public function getUser(bool $as = false, ?bool $force = null): ?UserInterface;
    
    abstract public function setUser(?UserInterface $user): void;
    
    abstract public function getUserAs(): ?UserInterface;
    
    abstract public function setUserAs(?UserInterface $user): void;
    
    abstract public function getUserId(bool $as = false): ?int;
    
    abstract public function getUserAsId(): ?int;
    
    abstract public function getRoleList(): array;
    
    abstract public function getGroupList(): array;
    
    abstract public function getTypeList(): array;
    
    abstract public function isLoggedIn(bool $as = false, bool $force = false): bool;
    
    abstract public function isLoggedInAs(bool $force = false): bool;
    
    abstract public function findUserById(int $id): ?UserInterface;
    
    abstract public function findUserByEmail(string $string): ?UserInterface;
}
