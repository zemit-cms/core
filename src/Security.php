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

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;
use Zemit\Bootstrap\Config;

/**
 * Class Security
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit
 */
class Security extends \Phalcon\Encryption\Security
{
    protected $permissions = null;
    
    /**
     * Returns an existing or new access control list
     *
     * @param array $componentNames
     * @param array|null $permissions
     * @param string $inherit
     *
     * @return AclList
     */
    public function getAcl(array $componentNames = ['components'], ?array $permissions = null, string $inherit = 'inherit')
    {
        $acl = new Memory();
        
        $aclRoleList = [];
    
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        $this->permissions ??= $config->get('permissions');
    
        $permissions ??= $this->permissions->toArray() ?? [];
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
            
            foreach ($componentNames as $componentName) {
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
            $inheritList = is_array($inheritList)? $inheritList : [$inheritList];
            foreach ($inheritList as $inheritRole) {
                $acl->addInherit($aclRoleList[$role], $aclRoleList[$inheritRole]);
            }
        }
        
        
        return $acl;
    }
}
