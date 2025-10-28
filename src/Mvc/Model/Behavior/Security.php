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

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Di\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Acl\Adapter\AdapterInterface;
use Zemit\Mvc\Model\Behavior\Traits\ProgressTrait;
use Zemit\Mvc\Model\Behavior\Traits\SkippableTrait;
use Zemit\Identity\Manager as Identity;

/**
 * The Security class provides methods for access control and permission checking.
 * This behavior will stop operations if the user is not allowed to run a certain type of action for the model
 */
class Security extends Behavior
{
    use SkippableTrait;
    use ProgressTrait;
    
    public static ?array $roles = null;
    public static ?AdapterInterface $acl = null;
    
    /**
     * Set the Access Control List (ACL) adapter.
     *
     * @param AdapterInterface|null $acl The ACL adapter to set. Defaults to null.
     * @return void
     */
    public static function setAcl(?AdapterInterface $acl = null): void
    {
        self::$acl = $acl;
    }
    
    /**
     * Get the Access Control List (ACL) with models and components elements
     *
     * @return AdapterInterface The ACL adapter instance
     */
    public static function getAcl(): AdapterInterface
    {
        if (is_null(self::$acl)) {
            $acl = Di::getDefault()->get('acl');
            assert($acl instanceof \Zemit\Acl\Acl);
            self::setAcl($acl->get(['models', 'components']));
        }
        assert(self::$acl instanceof AdapterInterface);
        return self::$acl;
    }
    
    /**
     * Set the roles
     *
     * @param array|null $roles The roles to set. Defaults to null.
     *
     * @return void
     */
    public static function setRoles(?array $roles = null): void
    {
        self::$roles = $roles;
    }
    
    /**
     * Get the roles of the current user
     *
     * This method retrieves the roles of the current user from the identity object. If the roles have not been
     * retrieved before, it retrieves them using the 'getAclRoles' method of the identity object. If the roles
     * have already been retrieved, it returns the cached roles. If the identity object is not found in the
     * DI container, an exception will be thrown.
     *
     * @return array The roles of the current user
     */
    public static function getRoles(): array
    {
        if (!isset(self::$roles)) {
            $identity = Di::getDefault()->get('identity');
            assert($identity instanceof Identity);
            self::setRoles($identity->getAclRoles());
        }
        return self::$roles ?? [];
    }
    
    /**
     * @param string $type The type of event to notify. Should be one of the following:
     *                     'beforeFind', 'beforeFindFirst', 'beforeCount', 'beforeSum', 'beforeAverage', 'beforeCreate', 
     *                     'beforeUpdate', 'beforeDelete', 'beforeRestore', 'beforeReorder'.
     * @param ModelInterface $model The model associated with the event.
     * 
     * @return bool|null Returns true if the event is allowed, false otherwise.
     *                   Returns null if the notification is disabled or if the check is skipped while in progress.
     */
    #[\Override]
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        // skip check while still in progress
        // needed to retrieve roles for itself
        if ($this->inProgress()) {
            return null;
        }
        
        $beforeEvents = [
            'beforeFind' => true,
            'beforeFindFirst' => true,
            'beforeCount' => true,
            'beforeSum' => true,
            'beforeAverage' => true,
            'beforeCreate' => true,
            'beforeUpdate' => true,
            'beforeDelete' => true,
            'beforeRestore' => true,
            'beforeReorder' => true,
        ];
        
        if ($beforeEvents[$type] ?? false) {
            self::staticStart();
            
            $type = (str_starts_with($type, 'before')) ? lcfirst(substr($type, 6)) : $type;
            $isAllowed = $this->isAllowed($type, $model);
            
            self::staticStop();
            return $isAllowed;
        }
        
        return true;
    }
    
    /**
     * Check if a specified type of operation is allowed on a model
     *
     * @param string $type The type of operation to check
     * @param ModelInterface $model The model to check permissions on
     * @param AdapterInterface|null $acl The ACL adapter to use for permission checks (optional, will default to the configured ACL if not provided)
     * @param array|null $roles The roles to check for permission (optional, will use the configured roles if not provided)
     * 
     * @return bool Returns true if the operation is allowed, false otherwise
     */
    public function isAllowed(string $type, ModelInterface $model, ?AdapterInterface $acl = null, ?array $roles = null): bool
    {
        $acl ??= self::getAcl();
        $modelClass = get_class($model);
        
        // component not found
        if (!$acl->isComponent($modelClass)) {
            $model->appendMessage(new Message(
                'Model permission not found for `' . $modelClass . '`',
                'id',
                'NotFound',
                404
            ));
            return false;
        }
        
        // allowed for roles
        $roles ??= self::getRoles();
        foreach ($roles as $role) {
            if ($acl->isAllowed($role, $modelClass, $type)) {
                return true;
            }
        }
        
        $model->appendMessage(new Message(
            'Current identity forbidden to execute `' . $type . '` on `' . $modelClass . '`',
            'id',
            'Forbidden',
            403
        ));
        return false;
    }
}
