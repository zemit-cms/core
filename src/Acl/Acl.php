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
     * Retrieves the ACL (Access Control List) based on the provided components and permissions.
     *
     * @param array $componentsName An array of component names to include in the ACL. Defaults to ['components'].
     * @param array|null $permissions The permissions array to use for building the ACL. Defaults to null.
     * @param string $inherit The type of role inheritance to use. Defaults to 'inherit'.
     *
     * @return Memory The ACL (Access Control List) object.
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
                        $acl->allow((string)$aclRole, (string)$aclComponent, $accessList);
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
                $acl->addInherit((string)$aclRole, $aclRoleList[$inheritRole]);
            }
        }
        
        return $acl;
    }
}
