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

/***
 * Zemit\Provider\Security\Security
 *
 * This component provides a set of functions to improve the security in Forum application.
 * Prefixed version.
 *
 * <code>
 * $login = $this->request->getPost('login');
 * $password = $this->request->getPost('password');
 *
 * $user = Users::findFirstByLogin($login);
 * if ($user && $this->security->checkHash($password, $user->password)) {
 *     //The password is valid
 * }
 * </code>
 *
 * @package Zemit\Provider\Security
 * @property \Phalcon\Security\Random $_random
 */
class Security extends \Phalcon\Security
{
    protected $permissions = null;
    
    /**
     * Returns an existing or new access control list
     *
     * @param $permissions
     * @param string $componentName
     * @param string $models
     * @param string $inherit
     *
     * @return AclList
     */
    public function getAcl(string $componentName = 'components', array $permissions = null, string $inherit = 'inherit')
    {
        $acl = new Memory();
        
        $aclRoleList = [];
    
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        $this->permissions ??= $config->get('permissions');
        
        $permissions ??= $this->permissions->roles->toArray() ?? [];
        foreach ($permissions as $role => $rolePermission) {
            $role = $role === '*' ? 'everyone' : $role;
            $aclRole = new Role($role);
            
            $aclRoleList[$role] = $aclRole;
            
            $acl->addRole($aclRole);
            
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
