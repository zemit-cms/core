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

/**
 * Trait Identity
 * @package Zemit\Mvc\Model
 */
trait Identity
{
    /**
     * Get the current identity instance from the DI
     *
     * @return \Zemit\Identity
     */
    public function getIdentity() {
        
        /** @var \Zemit\Identity $identity */
        $identity = $this->getDI()->get('identity');
        
        return $identity;
    }
    
    /**
     * Return true or false whether a user is logged in or not into the current session
     *
     * @return bool
     */
    public function isLoggedIn($as = false) {
        return $this->getIdentity()->isLoggedIn($as);
    }
    
    /**
     * Return true or false whether a user is logged in as or not into the current session
     *
     * @return bool
     */
    public function isLoggedInAs() {
        return $this->isLoggedIn(true);
    }
    
    /**
     * Get the current active user using the identity service
     *
     * @param bool $as
     *
     * @return bool|\Zemit\Models\User
     */
    public function getCurrentUser($as = false)
    {
        return $this->getIdentity()->getUser($as);
    }
    
    /**
     * Get the current user id
     *
     * @param bool $as
     *
     * @return |null
     */
    public function getCurrentUserId($as = false)
    {
        $user = $this->getCurrentUser($as);
        
        return $user ? $user->getId() : null;
    }
    
    /**
     * @return \Closure
     */
    public function getCurrentUserIdCallback($as = false)
    {
        return function () use ($as) {
            
            return $this->getCurrentUserId($as);
        };
    }
}
