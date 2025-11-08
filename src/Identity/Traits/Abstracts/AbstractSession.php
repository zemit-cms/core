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

namespace PhalconKit\Identity\Traits\Abstracts;

trait AbstractSession
{
    abstract public function getSessionKey(bool $refresh = false): string;
    
    abstract public function removeSessionIdentity(): void;
    
    abstract public function setSessionIdentity(array $identity): void;
    
    abstract public function getSessionIdentity(): array;
    
    abstract public function hasSessionIdentity(): bool;
    
    abstract public function getKey(): ?string;
}
