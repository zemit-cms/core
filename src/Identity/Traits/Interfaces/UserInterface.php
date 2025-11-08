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

namespace PhalconKit\Identity\Traits\Interfaces;

use PhalconKit\Models\Interfaces\UserInterface as UserModelInterface;

interface UserInterface
{
    public function getUser(bool $as = false, ?bool $force = null): ?UserModelInterface;
    
    public function setUser(?UserModelInterface $user): void;
    
    public function getUserAs(): ?UserModelInterface;
    
    public function setUserAs(?UserModelInterface $user): void;
    
    public function getUserId(bool $as = false): ?int;
    
    public function getUserAsId(): ?int;
    
    public function getRoleList(): array;
    
    public function getGroupList(): array;
    
    public function getTypeList(): array;
    
    public function isLoggedIn(bool $as = false, bool $force = false): bool;
    
    public function isLoggedInAs(bool $force = false): bool;
    
    public function findUserById(int $id): ?UserModelInterface;
    
    public function findUserByEmail(string $string): ?UserModelInterface;
}
