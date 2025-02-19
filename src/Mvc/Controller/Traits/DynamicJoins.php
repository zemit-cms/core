<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

use Phalcon\Filter\Exception;
use Zemit\Support\Helper;

trait DynamicJoins
{
    protected ?array $dynamicJoins = null;
    protected array $dynamicJoinsMapping = [];
    
    public function getJoins()
    {
        return $this->dynamicJoins ?? $this->getDynamicJoinsFromFilters();
    }
    
    public function getDynamicJoins(): array
    {
        return [];
    }
    
    /**
     * @throws Exception
     */
    public function getDynamicJoinsFromFilters(?array $filters = null): array
    {
        $filters ??= $this->getParam('filters');
        
        if (!isset($filters) || !is_array($filters)) {
            return [];
        }
        
        // prepare dynamic joins
        if (!isset($this->dynamicJoins)) {
            $this->dynamicJoins = [];
        }
        
        foreach ($filters as $filter) {
            
            // loop through filters subgroups
            if (is_array($filter) && isset($filter[0])) {
                $this->dynamicJoins = array_merge(
                    $this->dynamicJoins,
                    $this->getDynamicJoinsFromFilters($filter)
                );
            }
            
            // skip if no field is defined
            if (!isset($filter['field'])) {
                continue;
            }
            
            // skip if not a relationship field
            if (!str_contains($filter['field'], '.')) {
                continue;
            }
            
            // prepare field without array brackets
            $filteredField = preg_replace('/\[[^\]]*\](?=\.)/', '', $filter['field']);
            $prospectAlias = preg_replace('/\.[^.]*$/', '', $filteredField);
            
            $dynamicJoins = $this->getDynamicJoins();
            foreach ($dynamicJoins as $dynamicJoinAlias => $dynamicJoin) {
                
                // if prospect alias doesn't match any dynamic join alias, skip
                if ($prospectAlias !== $dynamicJoinAlias) {
                    continue;
                }
                
                // prepare replaces for conditions
                $replaces = [];
                
                // prepare the field alias
                $fieldAlias = '';
                
                // explode each parts of the nesting relationship
                $fieldParts = explode('.', $filter['field']);
                
                // only keep relationships from the field parts
                array_pop($fieldParts);
                
                // loop through each steps
                foreach ($fieldParts as $fieldPartAlias) {
                    // build the full field alias with the context
                    $fieldAlias .= (empty($fieldAlias)? '' : '.') . $fieldPartAlias;
                    
                    // filter field alias to get raw alias by removing brackets
                    $alias = preg_replace('/\[[^\]]*\]/', '', $fieldAlias);
                    
                    // the join alias must be defined
                    if (!isset($dynamicJoins[$alias])) {
                        throw new \Exception('Dynamic join alias not defined for `' . $alias . '`');
                    }
                    
                    // prepare the dynamic joins alias mapping
                    $joinAlias = $this->dynamicJoinsMapping[$fieldAlias] ??= uniqid('_') . '_';
                    
                    // append this replace definition for this joins and other joins of the same deviation
                    $replaces['[' . $alias . '].'] = '[' . $joinAlias . '].';
                    
                    // if the join part alias is defined and the dynamic join alias never created
                    if (!isset($this->dynamicJoins[$joinAlias])) {
                        
                        // force join condition to be an array
//                        if (!is_array($dynamicJoins[$alias][1])) {
//                            $dynamicJoins[$alias][1] = [$dynamicJoins[$alias][1]];
//                        }
                        
                        // generate the join filter conditions
                        $joinFilters = $this->getParam('joins');
                        $condition = !empty($joinFilters[$fieldAlias])? $this->getFilterCondition($joinFilters[$fieldAlias]) : '';
                        
                        // prepare the dynamic join
                        $dynamicJoin = [
                            
                            // model class to use
                            $dynamicJoins[$alias][0],
                            
                            // update the join condition to use the dynamic join alias
                            '(' . str_replace(array_keys($replaces), array_values($replaces), $dynamicJoins[$alias][1]) . ')'
                            . (empty($condition)? '' : ' and (' . $condition . ')'),
//                            Helper::recursiveStrReplace($dynamicJoins[$alias][1], $replaces),
                            
                            // use generated alias
                            $joinAlias,
                            
                            // join type left by default
                            $joins[$alias][3] ?? 'left'
                        ];
                        
                        // add the new dynamic join alias
                        $this->dynamicJoins[$joinAlias] = $dynamicJoin;
                    }
                }
            }
        }
        
        // ensure the children (longest mapping) gets replaced before their parents
        uksort($this->dynamicJoinsMapping, function ($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });
        
//        dd($this->dynamicJoins);
        return $this->dynamicJoins;
    }
    
    /**
     * Retrieves the join definitions for a given field by analyzing its relationship parts.
     *
     * @param string $field The field for which to retrieve the join definitions, including its relationship hierarchy.
     * @return array An array containing the join definitions for the specified field, ordered in a manner suitable for processing.
     */
    public function getJoinsDefinitionFromField(string $field): array
    {
        // prepare the field relationship parts
        $fieldParts = explode('.', $field);
        
        // remove the field part
        array_pop($fieldParts);
        
        // no relationship parts so we don't have joins
        if (empty($fieldParts)) {
            return [];
        }
        
        // prepare return value
        $ret = [];
        
        // pre-fetch the joins first
        $joins = $this->getJoins();
        
        // prepare alias with context
        $alias = '';
        
        foreach ($fieldParts as $fieldPart) {
            
            // build the full alias with context
            $alias .= (empty($alias)? '' : '.') . $fieldPart;
            
            // check if we have dynamic alias for this alias
            $dynamicAlias = $this->dynamicJoinsMapping[$alias] ??= $alias;
            
            // dynamic alias specifically defined, use this
            if (isset($joins[$dynamicAlias])) {
                $ret []= $joins[$dynamicAlias];
            }
            
            // alias specifically defined, use this
            elseif (isset($joins[$alias])) {
                $ret []= $joins[$alias];
            }
            
            // joins not specifically defined, fallback using native phalcon way
            else {
                
                // loop through each defined joins
                foreach ($joins as $join) {
                    
                    // join found using dynamic alias
                    if ($join[2] === $dynamicAlias) {
                        $ret []= $join;
                    }
                    
                    // join found using alias
                    elseif ($join[2] === $alias) {
                        $ret []= $join;
                    }
                }
            }
        }
        
        // return in reverse order as the first should be the longest alias
        return array_reverse($ret);
    }
    
    public function setDynamicNestedJoin(string &$field, string|array $startWith, array $joins): bool
    {
        // only set dynamic joins if the current field is allowed
        $allowedField = preg_replace('/\[[^]]*]/', '', $field);
        if (!in_array($allowedField, $this->filterWhiteList, true)) {
            return false;
        }
        
        // to support multiple nested sets of relationships with deviations
        if (!is_array($startWith)) {
            $startWith = [$startWith];
        }
        
        // process each deviation
        foreach ($startWith as $with) {
            
            // prepare the new field to be replaced and allowed
            $newField = '';
            
            // prepare the full alias with context
            $alias = '';
            
            // explode each parts of the nesting relationship
            $withParts = explode('.', $with);
            
            // prepare replaces for conditions
            $replaces = [];
            
            // loop through each steps
            foreach ($withParts as $partAlias) {
                // build the full alias with the context to avoid collisions
                $alias .= (empty($alias)? '' : '.') . $partAlias;
                
                // the current field must start with the alias with context
                if (!str_starts_with($allowedField, $alias)) {
                    break;
                }
                
                // the join alias must be defined
                if (!isset($joins[$partAlias])) {
                    throw new \Exception('Join alias not defined for `' . $alias . '`');
                }
                
                // prepare the dynamic joins alias mapping
                $joinAlias = $this->dynamicJoinsMapping[$alias] ??= uniqid('_') . '_';
                
                // append this replace definition for this joins and other joins of the same deviation
                $replaces['[' . $partAlias . '].'] = '[' . $joinAlias . '].';
                
                // if the join part alias is defined and the dynamic join alias never created
                if (!isset($this->dynamicJoins[$joinAlias])) {
                    
                    // force join condition to be an array
                    if (!is_array($joins[$partAlias][1])) {
                        $joins[$partAlias][1] = [$joins[$partAlias][1]];
                    }
                    
                    // generate the join filter conditions
//                    $joinFilters = $this->getParam('joins');
//                    dd($this->getFilterCondition($joinFilters['RecordTag[29].Tag']), $this->getBind());
                    
                    // prepare the dynamic join
                    $dynamicJoin = [
                        
                        // model class to use
                        $joins[$partAlias][0],
                        
                        // update the join condition to use the dynamic join alias
                        Helper::recursiveStrReplace($joins[$partAlias][1], $replaces),
                        
                        // use generated alias
                        $joinAlias,
                        
                        // join type left by default
                        $joins[$partAlias][3] ?? 'left'
                    ];
                    
                    // add the new dynamic join alias
                    $this->dynamicJoins[$joinAlias] = $dynamicJoin;
                }
                
                $newField = $joinAlias . '.' . preg_replace('/^.*\./', '', $field);
            }
            
            if (!empty($newField)) {
                $field = $newField;
                $this->dynamicJoinsAllowed[$newField] = true;
            }
        }
        
        return false;
    }
    
    /**
     * Sets a dynamic join for a field that matches a specified prefix and updates its configuration.
     *
     * @param string &$field The field that needs to be updated with the join alias.
     * @param string $class The class or table name to be used in the join condition.
     * @param array|string $startWith The prefix that the field must start with to trigger a dynamic join.
     * @param string|array $condition The joins condition to apply for the dynamic joins.
     * @param string $type The type of join to apply (e.g., 'outer left'). Default is 'outer left'.
     * @return bool Returns true if a dynamic join is successfully applied, otherwise false.
     */
    public function setDynamicJoin(string &$field, string $class, string|array $startWith, string|array $condition, string $type = 'left'): bool
    {
        // if not a relationship field that starts with the startWith, return false immediately
        if (!str_starts_with($field, $startWith . '.') && !preg_match('/^' . preg_quote($startWith, '/') . '\[[^]]*\]\./', $field)) {
            return false;
        }
        
        // Retrieve the field in "allowed field" form
        $allowedField = $field = preg_replace('/\[[^]]*]/', '', $field);
        
        // Check if the field is allowed from the filter whitelist
        if (in_array($allowedField, $this->filterWhiteList, true)) {
            
            // Find the relationship alias from the filter field
            $fieldPath = explode('.', $field);
            
            // join alias is always unique if the field relationship alias ends with []
            $fieldPath[0] = str_ends_with($fieldPath[0], '[]') ? uniqid('_') . '_' : $fieldPath[0];
            
            // Find or create the join alias from the filter field relationship alias
            $joinAlias = $this->dynamicJoinsMapping[$fieldPath[0]] ??= uniqid('_') . '_';
            
            // Reconstruct the field with the generated join alias
            $fieldPath[0] = $joinAlias;
            $field = implode('.', $fieldPath);
            
            // allow multiple joins
            if (!is_array($condition)) {
                $condition = [$class => $condition];
            }
            
            // build each individual joins for this field
            foreach ($condition as $joinClass => $joinCondition) {
                
                // Reconstruct the join condition with the generated join alias
                $joinCondition = str_replace('[' . $class . '].', '[' . $joinAlias . '].', $joinCondition);
                
                // Set the dynamic join
                $joinAs = $class === $joinClass? $joinAlias : $joinClass;
                $this->dynamicJoins[$joinAs] ??= [$joinClass, $joinCondition, $joinAs, $type];
            }
            
            // Allow this dynamic field
            $this->dynamicJoinsAllowed[$field] = true;
            
            // join successfully applied
            return true;
        }
        
        // no dynamic join
        return false;
    }
}
