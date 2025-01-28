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

namespace Zemit\Identity\Traits;

use Zemit\Di\AbstractInjectable;

trait Session
{
    use AbstractInjectable;
    
    public const SESSION_KEY = 'zemit-identity';
    
    public function getSessionKey(bool $refresh = false): string
    {
        return $this->getOption('sessionKey', self::SESSION_KEY) . ($refresh ? '-refresh' : '');
    }
    
    public function removeSessionIdentity(): void
    {
        $key = $this->getKey();
        if ($key) {
            $this->session->remove($key);
        }
    }
    
    public function setSessionIdentity(array $identity): void
    {
        $key = $this->getKey();
        if ($key) {
            $this->session->set($key, $identity);
        }
    }
    
    public function getSessionIdentity(): array
    {
        $key = $this->getKey();
        return ($key ? $this->session->get($key) : null) ?? [];
    }
    
    public function hasSessionIdentity(): bool
    {
        $key = $this->getKey();
        return $key && $this->session->has($key);
    }
    
    public function getKey(): ?string
    {
        return $this->getClaim()['key'] ?? null;
    }
}
