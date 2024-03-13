<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;

trait PermissionConditions
{
    use AbstractInjectable;
    use AbstractModel;
    use AbstractQuery;
    
    protected ?Collection $permissionConditions;
    
    public function initializePermissionConditions(): void
    {
        $this->setPermissionConditions(new Collection([
            'default' => $this->defaultPermissionCondition(),
        ], false));
    }
    
    public function setPermissionConditions(?Collection $permissionConditions): void
    {
        $this->permissionConditions = $permissionConditions;
    }
    
    public function getPermissionConditions(): ?Collection
    {
        return $this->permissionConditions;
    }
    
    /**
     * Builds the permission condition based on the current user's identity and role.
     *
     * @return array|string|null Returns an array with the following elements:
     *                         - If permission columns are empty, returns null.
     *                         - If no permission is found, returns ['false'].
     *                         - If the current user role is a super admin, returns ['true'].
     *                         - If permission conditions are found, returns an array with the following elements:
     *                           - The condition string formed by joining the columns with 'or' operators.
     *                           - An array of bind values for the condition.
     *                           - An array of bind types for the condition.
     */
    public function defaultPermissionCondition(): array|string|null
    {
        $columns = $this->getCreatedByColumns();
        $superRoleList = $this->getSuperRoles();
        
        if (empty($columns)) {
            return null;
        }
        
        // no identity found
        if (!isset($this->identity)) {
            return ['false'];
        }
        
        // check if current user role is a super admin
        if ($this->identity->hasRole($superRoleList)) {
            return ['true'];
        }
        
        $query = [];
        $bind = [];
        $bindTypes = [];
        $userId = (int)$this->identity->getUserId();
        
        foreach ($columns as $column) {
            $field = $this->appendModelName($column);
            $value = $this->generateBindKey('deleted');
            
            $bind[$field] = $userId;
            $bindTypes[$field] = Column::BIND_PARAM_INT;
            
            $query [] = "{$field} = :{$value}:";
        }
        
        return [
            implode(' or ', $query),
            $bind,
            $bindTypes,
        ];
    }
    
    /**
     * Retrieves the owner id columns of the current model.
     *
     * @return array The permission columns.
     */
    public function getCreatedByColumns(): array
    {
        return ['createdBy'];
    }
    
    /**
     * Retrieves the list of super admins roles.
     * These roles are authorized through the Permission Conditions
     *
     * @return array The list of super roles, which by default includes 'dev' and 'admin'.
     */
    public function getSuperRoles(): array
    {
        return ['dev', 'admin'];
    }
}
