<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Phalcon\Encryption\Security as PhalconSecurity;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;
use Zemit\Config\ConfigInterface;

/**
 * {@inheritDoc}
 */
class Security extends PhalconSecurity
{
    protected ?array $permissions;
    
    public function getPermissionsConfig(): array
    {
        return $this->getConfig()->pathToArray('permissions') ?? [];
    }
    
    public function getConfig(): ConfigInterface
    {
        return $this->getDI()->get('config');
    }
    
    public function hash(string $password, array $options = []) : string
    {
        if (in_array($this->getDefaultHash(), [
            PhalconSecurity::CRYPT_ARGON2I,
            PhalconSecurity::CRYPT_ARGON2ID
        ])) {
            $defaultOptions = $this->getConfig()->pathToArray('security.argon2');
            $options['memory_cost'] ??= $defaultOptions['memoryCost'];
            $options['time_cost'] ??= $defaultOptions['timeCost'];
            $options['threads'] ??= $defaultOptions['threads'];
        }
        
        return parent::hash($password, $options);
    }
    
    /**
     * Return an ACL for the specified components name
     * @param array $componentsName
     * @param array|null $permissions
     * @param string $inherit
     * @return Memory
     * @todo cache the ACL
     * @todo move to its own ACL class, shouldn't be in the Phalcon\Encryption\Security
     */
    public function getAcl(array $componentsName = ['components'], ?array $permissions = null, string $inherit = 'inherit'): Memory
    {
        $acl = new Memory();
        $aclRoleList = [];
        
        $this->permissions = $this->getPermissionsConfig();
        
        $featureList = $this->permissions['features'] ?? [];
        $roleList = $this->permissions['roles'] ?? [];
        
        foreach ($roleList as $role => $rolePermission) {
            
            $role = $role === '*' ? 'everyone' : $role;
            $aclRole = new Role($role);
            $aclRoleList[$role] = $aclRole;
            $acl->addRole($aclRole);
            
            if (isset($rolePermission['features'])) {
                foreach ($rolePermission['features'] as $feature) {
                    $rolePermission = array_merge_recursive($rolePermission, $featureList[$feature] ?? []);
                    // @todo remove duplicates
                }
            }
            
            foreach ($componentsName as $componentName) {
                $components = $rolePermission[$componentName] ?? [];
                $components = is_array($components) ? $components : [$components];
                
                foreach ($components as $component => $accessList) {
                    if (empty($component)) {
                        $component = $accessList;
                        $accessList = '*';
                    }
                    
                    if ($component !== '*') {
                        $aclComponent = new Component($component);
                        $acl->addComponent($aclComponent, $accessList);
                        $acl->allow($aclRole, $aclComponent, $accessList);
                    }
                }
            }
        }
        
        /**
         * Add inheritance (role extends)
         */
        foreach ($aclRoleList as $role => $aclRole) {
            $inheritList = $permissions[$role][$inherit] ?? [];
            $inheritList = is_array($inheritList) ? $inheritList : [$inheritList];
            foreach ($inheritList as $inheritRole) {
                $acl->addInherit($aclRole, $aclRoleList[$inheritRole]);
            }
        }
        
        return $acl;
    }
}
