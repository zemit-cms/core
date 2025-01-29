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

interface SessionInterface
{
    public function getSessionKey(bool $refresh = false): string;
    
    public function removeSessionIdentity(): void;
    
    public function setSessionIdentity(array $identity): void;
    
    public function getSessionIdentity(): array;
    
    public function hasSessionIdentity(): bool;
    
    public function getKey(): ?string;
}
