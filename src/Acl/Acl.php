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
class Acl extends AbstractInjectionAware implements AclInterface
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
    #[\Override]
    public function get(array $componentsName = ['components'], ?array $permissions = null, string $inherit = 'inherit'): Memory
    {
        $acl = new Memory();
        $aclRoleList = [];
        
        $permissions ??= $this->getOption('permissions', []);
        $featureList = $permissions['features'] ?? [];
        $roleList = $permissions['roles'] ?? [];
        
        foreach ($roleList as $role => $rolePermission) {
            $role = $role === '*' ? 'everyone' : $role;
            $aclRole = new Role($role);
            $aclRoleList[$role] = $aclRole;
            $acl->addRole($aclRole);
            
            if (isset($rolePermission['features'])) {
                foreach ($rolePermission['features'] as $feature) {
                    if (!isset($featureList[$feature])) {
                        continue;
                    }
                    $rolePermission = array_merge_recursive($rolePermission, $featureList[$feature]);
                }
            }
            
            foreach ($componentsName as $componentName) {
                $components = $rolePermission[$componentName] ?? [];
                $components = is_array($components) ? $components : [$components];
                
                foreach ($components as $component => $accessList) {
                    // Support shorthand ['SomeController'] => '*'
                    if (is_int($component)) {
                        $component = $accessList;
                        $accessList = '*';
                    }
                    
                    if ($component === '*') {
                        continue;
                    }
                    
                    $aclAccess = is_array($accessList) ? array_values(array_unique(array_filter($accessList))) : [$accessList];
                    $aclComponent = new Component($component);
                    $acl->addComponent($aclComponent, $aclAccess);
                    $acl->allow((string)$aclRole, (string)$aclComponent, $aclAccess);
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
