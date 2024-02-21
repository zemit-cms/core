<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Models\Interfaces\UserInterface;

/**
 * This trait provides convenient methods for managing user identity and authentication within a model.
 * It encapsulates the logic related to user authentication and session management,
 * making it easier to reuse and maintain in different models.
 */
trait Identity
{
    use AbstractInjectable;
    
    /**
     * Get the current identity service from the DI
     */
    public function getIdentity(): \Zemit\Identity
    {
        return $this->getDI()->get('identity');
    }

    /**
     * Return true or false whether a user is logged in or not into the current session
     */
    public function isLoggedIn(bool $as = false): bool
    {
        return $this->getIdentity()->isLoggedIn($as);
    }

    /**
     * Return true or false whether a user is logged in as or not into the current session
     */
    public function isLoggedInAs(): bool
    {
        return $this->isLoggedIn(true);
    }

    /**
     * Get the current active user using the identity service
     */
    public function getCurrentUser(bool $as = false): ?UserInterface
    {
        return $this->getIdentity()->getUser($as);
    }
    
    /**
     * Get the current active user using the identity service
     */
    public function getCurrentUserAs(): ?UserInterface
    {
        return $this->getCurrentUser(true);
    }

    /**
     * Get the current user id
     */
    public function getCurrentUserId(bool $as = false): ?int
    {
        $user = $this->getCurrentUser($as);
        return $user?->getId();
    }
    
    /**
     * Get current user id callable (used for events behaviors)
     */
    public function getCurrentUserIdCallback(bool $as = false): \Closure
    {
        return function () use ($as) {
            return $this->getCurrentUserId($as);
        };
    }
}
