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

namespace Zemit\Mvc\Controller\Traits\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;

trait IdentityConditions
{
    use AbstractModel;
    use AbstractParams;
    use AbstractQuery;
    
    protected ?Collection $identityConditions = null;
    
    public function initializeIdentityConditions(): void
    {
        $this->setIdentityConditions(new Collection([
            'default' => $this->defaultIdentityCondition(),
        ], false));
    }
    
    public function setIdentityConditions(?Collection $identityConditions): void
    {
        $this->identityConditions = $identityConditions;
    }
    
    public function getIdentityConditions(): ?Collection
    {
        return $this->identityConditions;
    }
    
    /**
     * Builds the identity condition based on the current user's identity and role.
     *
     * @return array|string|null Returns an array with the following elements:
     *                         - If identity columns are empty, returns null.
     *                         - If no identity is found, returns ['false'].
     *                         - If the current user role is a super admin, returns ['true'].
     *                         - If identity conditions are found, returns an array with the following elements:
     *                           - The condition string formed by joining the columns with 'or' operators.
     *                           - An array of bind values for the condition.
     *                           - An array of bind types for the condition.
     */
    public function defaultIdentityCondition(): array|string|null
    {
        $columns = $this->getIdentityColumns();
        
        if (empty($columns)) {
            return null;
        }
        
        $query = [];
        $bind = [];
        $bindTypes = [];
        
        foreach ($columns as $column) {
            $rawValue = $this->getParam($column, [Filter::FILTER_STRING, Filter::FILTER_TRIM]);
            if (!isset($rawValue)) {
                continue;
            }
            
            $field = $this->appendModelName($column);
            $value = $this->generateBindKey('identity');
            
            $bind[$value] = $rawValue;
            $bindTypes[$value] = Column::BIND_PARAM_STR;
            
            $query [] = "{$field} = :{$value}:";
        }
        
        return empty($query) ? null : [
            implode(' and ', $query),
            $bind,
            $bindTypes,
        ];
    }
    
    /**
     * Retrieves the identity columns of the current model.
     *
     * @return array The identity columns.
     */
    public function getIdentityColumns(): array
    {
        // @todo get primary keys from the model
        return ['id', 'uuid'];
    }
}
