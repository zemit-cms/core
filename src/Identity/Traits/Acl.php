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

use Phalcon\Acl\Role;

trait Acl
{
    /**
     * Return the list of ACL roles
     * - role `cli` is automatically added if the bootstrap mode is console/cli
     * - role `everyone` is automatically added to everyone at all time
     * - role `guest` is automatically added only if no role was found
     * - inherited roles are automatically added from the base roles
     *
     * @param array|null $roleList
     * @return array
     */
    public function getAclRoles(?array $roleList = null): array
    {
        $aclRoles = [];
        
        // Add console role
        if ($this->bootstrap->isCli()) {
            $aclRoles['cli'] = new Role('cli');
        }
        
        // Add everyone role
        $aclRoles['everyone'] = new Role('everyone');
        
        // Fetch current identity roles
        $roleList ??= array_keys($this->getRoleList());
        
        // Add guest role if no roles was detected
        if (empty($roleList)) {
            $aclRoles['guest'] = new Role('guest');
        }
        
        else {
            // Add roles from databases
            foreach ($roleList as $role) {
                $aclRoles[$role] ??= new Role($role);
            }
            
            // Add roles from inherited roles
            foreach ($this->getInheritedRoleList($roleList) as $role) {
                $aclRoles[$role] ??= new Role($role);
            }
        }
        
        return array_filter(array_values(array_unique($aclRoles)));
    }
}
