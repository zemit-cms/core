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

use Phalcon\Db\Column;
use Zemit\Models\Interfaces\UserInterface;
use Zemit\Mvc\Model\Behavior\Security as SecurityBehavior;

trait User
{
    protected ?UserInterface $user;
    protected ?UserInterface $userAs;
    
    /**
     * Return the user object based on the session
     *
     * @param bool $as Flag to indicate whether to get the user as another user
     * @param bool|null $force Flag to indicate whether to force the retrieval of the user object
     *
     * @return UserInterface|null The user object or null if session is not available
     */
    public function getUser(bool $as = false, ?bool $force = null): ?UserInterface
    {
        if (!$force) {
            if ($as && !empty($this->userAs)) {
                return $this->userAs;
            }
            elseif (!$as && !empty($this->user)) {
                return $this->user;
            }
        }
        
        $sessionIdentity = $this->getSessionIdentity();
        
        $userId = $as
            ? $sessionIdentity['asUserId'] ?? null
            : $sessionIdentity['userId'] ?? null;
        
        $user = null;
        if (!empty($userId)) {
            SecurityBehavior::staticStart();
            
            $user = $this->models->getUser()::findFirstWith([
                'RoleList',
                'GroupList',
                'TypeList',
            ], [
                'id = :id:',
                'bind' => ['id' => (int)$userId],
                'bindTypes' => ['id' => Column::BIND_PARAM_INT],
            ]);
            
            if ($user) {
                assert($user instanceof UserInterface);
            }
            
            SecurityBehavior::staticStop();
        }
        
        $as
            ? $this->setUserAs($user)
            : $this->setUser($user);
        
        return $user ?: null;
    }
    
    /**
     * Set Identity User
     */
    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }
    
    /**
     * Get Identity User (As)
     */
    public function getUserAs(): ?UserInterface
    {
        return $this->getUser(true);
    }
    
    /**
     * Set Identity User (As)
     */
    public function setUserAs(?UserInterface $user): void
    {
        $this->userAs = $user;
    }
    
    /**
     * Get the User ID
     */
    public function getUserId(bool $as = false): ?int
    {
        $user = $this->getUser($as);
        return isset($user) ? (int)$user->getId() : null;
    }
    
    /**
     * Get the User (As) ID
     */
    public function getUserAsId(): ?int
    {
        return $this->getUserId(true);
    }
    
    /**
     * Get the "Roles" related to the current session
     */
    public function getRoleList(): array
    {
        return $this->getIdentity()['roleList'] ?? [];
    }
    
    /**
     * Get the "Groups" related to the current session
     */
    public function getGroupList(): array
    {
        return $this->getIdentity()['groupList'] ?? [];
    }
    
    /**
     * Get the "Types" related to the current session
     */
    public function getTypeList(): array
    {
        return $this->getIdentity()['typeList'] ?? [];
    }
    
    /**
     * Return true if the user is currently logged in
     */
    public function isLoggedIn(bool $as = false, bool $force = false): bool
    {
        return (bool)$this->getUser($as, $force);
    }
    
    /**
     * Return true if the user is currently logged in
     */
    public function isLoggedInAs(bool $force = false): bool
    {
        return $this->isLoggedIn(true, $force);
    }
    
    /**
     * Get the User from the database using the ID
     */
    public function findUserById(int $id): ?UserInterface
    {
        return $this->models->getUser()::findFirst([
            'id = :id:',
            'bind' => ['id' => $id],
            'bindTypes' => ['id' => Column::BIND_PARAM_INT],
        ]);
    }
    
    /**
     * Get the user from the database using the username or email
     */
    public function findUserByEmail(string $string): ?UserInterface
    {
        return $this->models->getUser()::findFirst([
            'email = :email:',
            'bind' => [
                'email' => $string,
            ],
            'bindTypes' => [
                'email' => Column::BIND_PARAM_STR,
            ],
        ]);
    }
}
