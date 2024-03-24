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
use Phalcon\Filter\Exception;
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractSearchFields;

/**
 * This trait provides methods for managing search conditions.
 */
trait SearchConditions
{
    use AbstractParams;
    use AbstractModel;
    use AbstractQuery;
    use AbstractSearchFields;
    
    protected ?Collection $searchConditions;
    
    /**
     * Initializes the search conditions.
     *
     * @return void
     * @throws Exception
     */
    public function initializeSearchConditions(): void
    {
        $this->setSearchConditions(new Collection([
            'default' => $this->defaultSearchCondition(),
        ], false));
    }
    
    /**
     * Set the search conditions for this object.
     *
     * @param Collection|null $searchConditions The search conditions to be set.
     *
     * @return void
     */
    public function setSearchConditions(?Collection $searchConditions): void
    {
        $this->searchConditions = $searchConditions;
    }
    
    /**
     * Returns the search conditions.
     *
     * @return Collection|null The search conditions, represented as a collection.
     */
    public function getSearchConditions(): ?Collection
    {
        return $this->searchConditions;
    }
    
    /**
     * Generates the default search condition for the method.
     *
     * @return array|string|null The default search condition, represented as an array containing the query, bind parameters, and bind types.
     * @throws \Phalcon\Filter\Exception If an error occurs while filtering the search parameter.
     */
    public function defaultSearchCondition(): array|string|null
    {
        $searchList = array_values(array_filter(array_unique(
            explode(' ', $this->getParam('search', [
                Filter::FILTER_STRING,
                Filter::FILTER_TRIM]) ?? '')
        )));
        
        $query = [];
        $bind = [];
        $bindTypes = [];
        
        foreach ($searchList as $searchTerm) {
            $searchFields = $this->getSearchFields()?->toArray() ?? [];
            foreach ($searchFields as $searchField) {
                $field = $this->appendModelName($searchField);
                $value = $this->generateBindKey('search');
                
                $query [] = "{$field} like :{$value}:";
                $bind[$field] = '%' . $searchTerm . '%';
                $bindTypes[$field] = Column::BIND_PARAM_STR;
            }
        }
        
        return empty($query)? null : [
            implode(' or ', $query),
            $bind,
            $bindTypes,
        ];
    }
}
