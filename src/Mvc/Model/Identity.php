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

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Db\RawValue;

/**
 * Trait Identity
 * @package Zemit\Mvc\Model
 */
trait Identity
{
    /**
     * Get the current active user using the identity service
     *
     * @param bool $as
     *
     * @return bool|\Zemit\Models\User
     */
    public function getCurrentUser($as = false)
    {
        /** @var \Zemit\Identity $identity */
        $identity = $this->getDI()->get('identity');
        
        return $identity->getUser($as);
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
        return function() use ($as) {
            
            return $this->getCurrentUserId($as);
            
        };
    }
}
