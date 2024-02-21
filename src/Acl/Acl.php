<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Acl;

use Phalcon\Di\AbstractInjectionAware;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;
use Zemit\Support\Options\Options;

/**
 * Class Acl
 *
 * This class represents an Access Control List (ACL) and is used 
 * to configure and manage access permissions for different components.
 */
class Acl extends AbstractInjectionAware
{
    use Options;
    
    /**
     * Return an ACL for the specified components name
     * @param array $componentsName
     * @param array|null $permissions
     * @param string $inherit
     * @return Memory
     * @todo cache the ACL
     */
    public function get(array $componentsName = ['components'], ?array $permissions = null, string $inherit = 'inherit'): Memory
    {
        $acl = new Memory();
        $aclRoleList = [];
        
        $permissions = $this->getOption('permissions', []);
        $featureList = $permissions['features'] ?? [];
        $roleList = $permissions['roles'] ?? [];
        
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
