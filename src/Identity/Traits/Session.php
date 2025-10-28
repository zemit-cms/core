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
use Zemit\Identity\Traits\Abstracts\AbstractJwt;

trait Session
{
    use AbstractInjectable;
    use AbstractJwt;
    
    public const SESSION_KEY = 'zemit-identity';
    public const REFRESH_SUFFIX = '-refresh';
    
    /**
     * Retrieves the session key, optionally appending a refresh suffix.
     *
     * @param bool $refresh Indicates whether to append the '-refresh' suffix to the session key.
     * @return string The retrieved session key, with or without the refresh suffix.
     */
    public function getSessionKey(bool $refresh = false): string
    {
        return $this->getOption('sessionKey', self::SESSION_KEY) . ($refresh ? self::REFRESH_SUFFIX : '');
    }
    
    /**
     * Removes the session identity associated with the current instance, if a valid key exists.
     *
     * @return void
     */
    public function removeSessionIdentity(): void
    {
        $key = $this->getKey();
        if ($key) {
            $this->session->remove($key);
        }
    }
    
    /**
     * Sets the session identity by storing the provided identity data in the session.
     *
     * @param array $identity An associative array representing the identity data to be stored in the session.
     * @return void
     */
    public function setSessionIdentity(array $identity): void
    {
        $key = $this->getKey();
        if ($key) {
            $this->session->set($key, $identity);
        }
    }
    
    /**
     * Retrieves the session identity from the session storage.
     *
     * @return array An associative array representing the identity data retrieved from the session. Returns an empty array if no data is found.
     */
    public function getSessionIdentity(): array
    {
        $key = $this->getKey();
        return ($key ? $this->session->get($key) : null) ?? [];
    }
    
    /**
     * Checks if a session identity exists by verifying the presence of a valid key and its association in the session.
     *
     * @return bool Returns true if a session identity exists; otherwise, false.
     */
    public function hasSessionIdentity(): bool
    {
        $key = $this->getKey();
        return $key && $this->session->has($key);
    }
    
    /**
     * Retrieves the 'key' value from the claim array if it exists, or returns null.
     *
     * @return string|null The 'key' value from the claim array, or null if not found.
     */
    public function getKey(): ?string
    {
        return $this->getClaim()['key'] ?? null;
    }
}
