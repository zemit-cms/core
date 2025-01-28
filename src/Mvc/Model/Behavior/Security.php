<?php

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
 * Allows to check if the current identity is allowed to run some model actions
 * this behavior will stop operations if not allowed
 */
class Security extends Behavior
{
    use SkippableTrait;
    use ProgressTrait;
    
    public static ?array $roles = null;
    
    public static ?AdapterInterface $acl = null;
    
    /**
     * Set the ACL
     */
    public static function setAcl(?AdapterInterface $acl = null): void
    {
        self::$acl = $acl;
    }
    
    /**
     * Get the ACL
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
     * Set the current identity's roles
     */
    public static function setRoles(?array $roles = null): void
    {
        self::$roles = $roles;
    }
    
    /**
     * Return the current identity's acl roles
     */
    public static function getRoles(): array
    {
        if (!isset(self::$roles)) {
            $identity = Di::getDefault()->get('identity');
            assert($identity instanceof Identity);
            self::$roles = $identity->getAclRoles();
        }
        return self::$roles ?? [];
    }
    
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }
    
    /**
     * Handling security (acl) on before model's events
     */
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
            
            $type = (strpos($type, 'before') === 0) ? lcfirst(substr($type, 6)) : $type;
            $isAllowed = $this->isAllowed($type, $model);
            
            self::staticStop();
            return $isAllowed;
        }
        
        return true;
    }
    
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
