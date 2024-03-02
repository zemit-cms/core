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

use Zemit\Models\Interfaces\UserInterface;

interface IdentityInterface
{
    public function getIdentityService(): \Zemit\Identity;

    public function isLoggedIn(bool $as = false): bool;

    public function isLoggedInAs(): bool;

    public function getCurrentUser(bool $as = false): ?UserInterface;

    public function getCurrentUserAs(): ?UserInterface;

    public function getCurrentUserId(bool $as = false): ?int;

    public function getCurrentUserIdCallback(bool $as = false): \Closure;
}
