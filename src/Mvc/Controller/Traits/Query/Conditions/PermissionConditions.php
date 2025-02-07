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

/**
 * This trait provides methods for managing permission conditions for the query.
 */
trait PermissionConditions
{
    use AbstractInjectable;
    use AbstractModel;
    use AbstractQuery;
    
    /**
     * Holds the permission conditions collection.
     *
     * This variable stores the permission conditions in an associative array format. Each key represents a permission,
     * and the corresponding value represents the conditions associated with that permission. The conditions can be
     * nested within sub-arrays to handle complex permission structures.
     *
     * @var Collection|null
     */
    protected ?Collection $permissionConditions;
    
    /**
     * Initializes the permission conditions for the object.
     *
     * Sets the permission conditions using a new instance of Collection class.
     * The default permission condition is set using the defaultPermissionCondition method.
     *
     * @return void
     */
    public function initializePermissionConditions(): void
    {
        $this->setPermissionConditions(new Collection([
            'default' => $this->defaultPermissionCondition(),
        ], false));
    }
    
    /**
     * Sets the permission conditions for the current user's identity and role.
     *
     * @param Collection|null $permissionConditions The permission conditions to be set. Pass null if no conditions are required.
     *                                               A Collection object that contains the permission conditions.
     *                                               Each permission condition is expected to be an array with the following elements:
     *                                               - The condition string formed by joining the columns with 'or' operators.
     *                                               - An array of bind values for the condition.
     *                                               - An array of bind types for the condition.
     *                                               Example: [
     *                                                   'column1 = :value1:',
     *                                                   ['value1' => 'some value'],
     *                                                   ['value1' => Column::BIND_PARAM_STR],
     *                                               ]
     * @return void
     */
    public function setPermissionConditions(?Collection $permissionConditions): void
    {
        $this->permissionConditions = $permissionConditions;
    }
    
    /**
     * Retrieves the collection of permission conditions.
     *
     * @return Collection|null Returns the collection of permission conditions, or null if it is not set.
     */
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
            $value = $this->generateBindKey('permission');
            
            $bind[$value] = $userId;
            $bindTypes[$value] = Column::BIND_PARAM_INT;
            
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
     * @return array Returns an array of strings representing the column names containing the "created by" information.
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
