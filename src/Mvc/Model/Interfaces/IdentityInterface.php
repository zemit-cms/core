<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Mvc\Model\Interfaces;

use PhalconKit\Models\Interfaces\UserInterface;

interface IdentityInterface
{
    public function getIdentityService(): \PhalconKit\Identity\Manager;

    public function isLoggedIn(bool $as = false): bool;

    public function isLoggedInAs(): bool;

    public function getCurrentUser(bool $as = false): ?UserInterface;

    public function getCurrentUserAs(): ?UserInterface;

    public function getCurrentUserId(bool $as = false): ?int;

    public function getCurrentUserIdCallback(bool $as = false): \Closure;
}
