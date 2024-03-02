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

namespace Zemit\Mvc\Model\Traits;

use Zemit\Models\Interfaces\UserInterface;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractInjectable;

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
    public function getIdentityService(): \Zemit\Identity
    {
        return $this->getDI()->get('identity');
    }
    
    /**
     * Check if a user is logged in
     *
     * @param bool $as Optional parameter to specify the identity state to check
     * 
     * @return bool Returns true if the user is logged in, false otherwise
     */
    public function isLoggedIn(bool $as = false): bool
    {
        return $this->getIdentityService()->isLoggedIn($as);
    }
    
    /**
     * Check if the user is logged in as another user.
     *
     * @return bool True if the user is logged in as another user, false otherwise.
     */
    public function isLoggedInAs(): bool
    {
        return $this->isLoggedIn(true);
    }
    
    /**
     * Get the current user.
     *
     * @param bool $as If true, return the UserInterface object. Default is false.
     *
     * @return UserInterface|null Returns the current user as a UserInterface object if $as is true.
     *                           Returns null if there is no current user or the user is not found.
     */
    public function getCurrentUser(bool $as = false): ?UserInterface
    {
        return $this->getIdentityService()->getUser($as);
    }
    
    /**
     * Get the current delegated UserInterface object
     *
     * @return UserInterface|null The current user as UserInterface if available, null otherwise
     */
    public function getCurrentUserAs(): ?UserInterface
    {
        return $this->getCurrentUser(true);
    }
    
    /**
     * Retrieves the ID of the currently logged-in user.
     *
     * @param bool $as Optional flag indicating whether to retrieve the user as well.
     *                If set to true, the complete user object will be returned.
     *                If set to false (default), only the user ID will be returned.
     *
     * @return int|null If $as is true, it returns the ID of the currently logged-in user as an integer.
     *                 If $as is false, it returns null if there is no logged-in user or
     *                 the ID of the currently logged-in user as an integer.
     */
    public function getCurrentUserId(bool $as = false): ?int
    {
        $user = $this->getCurrentUser($as);
        return $user?->getId();
    }
    
    /**
     * Retrieves a callback function that returns the ID of the currently logged-in user.
     *
     * @param bool $as Optional flag indicating whether to retrieve the user as well.
     *                If set to true, the complete user object will be returned.
     *                If set to false (default), only the user ID will be returned.
     *
     * @return \Closure A callback function that, when invoked, returns the ID of the currently logged-in user.
     *                 The returned ID will be null if there is no logged-in user or an integer if the user is logged in.
     */
    public function getCurrentUserIdCallback(bool $as = false): \Closure
    {
        return function () use ($as) {
            return $this->getCurrentUserId($as);
        };
    }
}
