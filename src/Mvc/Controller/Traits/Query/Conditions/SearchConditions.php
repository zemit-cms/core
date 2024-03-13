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

trait SearchConditions
{
    protected ?Collection $searchConditions;
    
    public function initializeSearchConditions(): void
    {
        $this->setSearchConditions(new Collection([
            'default' => $this->defaultSearchCondition(),
        ], false));
    }
    
    public function setSearchConditions(?Collection $searchConditions): void
    {
        $this->searchConditions = $searchConditions;
    }
    
    public function getSearchConditions(): ?Collection
    {
        return $this->searchConditions;
    }
    
    public function defaultSearchCondition(): array|string|null
    {
        $conditions = [];
        
        $searchList = array_values(array_filter(array_unique(explode(' ', $this->getParam('search', 'string') ?? ''))));
        
        foreach ($searchList as $searchTerm) {
            $orConditions = [];
            $searchWhiteList = $this->getSearchFields();
            if ($searchWhiteList) {
                foreach ($searchWhiteList as $whiteList) {
                    
                    // Multidimensional arrays not supported yet
                    // @todo support this properly
                    if (is_array($whiteList)) {
                        continue;
                    }
                    
                    $searchTermBinding = '_' . uniqid() . '_';
                    $orConditions [] = $this->appendModelName($whiteList) . " like :$searchTermBinding:";
                    $this->setBind([$searchTermBinding => '%' . $searchTerm . '%']);
                    $this->setBindTypes([$searchTermBinding => Column::BIND_PARAM_STR]);
                }
            }
            
            if (!empty($orConditions)) {
                $conditions [] = '(' . implode(' or ', $orConditions) . ')';
            }
        }
        
        return empty($conditions) ? null : '(' . implode(' and ', $conditions) . ')';
    }
}
