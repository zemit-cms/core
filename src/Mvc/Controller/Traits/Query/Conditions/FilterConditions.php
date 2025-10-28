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
use Phalcon\Filter\Exception;
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractFilterFields;
use Zemit\Support\Helper\Arr\FlattenKeys;

trait FilterConditions
{
    use AbstractInjectable;
    use AbstractModel;
    use AbstractParams;
    use AbstractFilterFields;
    
    protected ?Collection $filterConditions = null;
    
    public function initializeFilterConditions(): void
    {
        $this->setFilterConditions(new Collection([
            'default' => $this->defaultFilterCondition(),
        ], false));
    }
    
    public function setFilterConditions(?Collection $filterConditions): void
    {
        $this->filterConditions = $filterConditions;
    }
    
    public function getFilterConditions(): ?Collection
    {
        return $this->filterConditions;
    }
    
    /**
     * Retrieves the filter condition based on the specified filters, allowed filters, and logical operator.
     *
     * @param array|null $filters An array of filters.
     * @param array|null $allowedFilters An array of allowed filters.
     * @param bool $or The logical operator to use for combining multiple filters. Default is false.
     * @return array|string|null The filter condition with the specified filters, or null if no filters are provided.
     *
     * @throws \Exception if a filter field property or filter operator property is empty, or if a filter field is not allowed.
     */
    public function defaultFilterCondition(?array $filters = null, ?array $allowedFilters = null, bool $or = false): array|string|null
    {
        $filters ??= $this->getParam('filters');
        
        // no filters
        if (empty($filters)) {
            return null;
        }
        
        $allowedFilters ??= $this->getFilterFields()?->toArray();
        
        $query = [];
        $bind = [];
        $bindTypes = [];
        foreach ($filters as $filter) {
            // nesting filtering, switch logical and append filter group
            if (isset($filter[0]) && is_array($filter[0])) {
                $defaultFilterCondition = $this->defaultFilterCondition($filter, $allowedFilters, !$or);
                if (is_string($defaultFilterCondition)) {
                    $query[] = $defaultFilterCondition;
                } elseif (is_array($defaultFilterCondition)) {
                    $query[] = $defaultFilterCondition[0] ?? null;
                    $bind[] = $defaultFilterCondition[1] ?? null;
                    $bindTypes[] = $defaultFilterCondition[2] ?? null;
                }
                continue;
            }
            
            // required field
            if (empty($filter['field'])) {
                throw new \Exception('A valid filter field property is required.', 400);
            }
            
            // required operator
            if (empty($filter['operator'])) {
                throw new \Exception('A valid filter operator property is required.', 400);
            }
            
            // filter string field
            $field = $this->filter->sanitize($filter['field'], [
                Filter::FILTER_STRING,
                Filter::FILTER_TRIM,
            ]);
            
            // allowed field
            if (!$this->isFilterAllowed($field, $allowedFilters ?? null)) {
                throw new \Exception(sprintf('Unauthorized filter field: "%s"', $field), 403);
            }
            
            $operator = $this->getFilterOperator($filter['operator']);
            
            if (empty($operator)) {
                throw new \Exception('The following filter operator is not allowed: `' . $filter['operator'] . '`', 403);
            }
            
            $filterId = $this->security->getRandom()->hex(8);
            $getValue = function (string $value) use ($filterId): string {
                return '_' . uniqid($filterId . '_' . $value . '_') . '_';
            };
            
            $value = $getValue('value');
            $field = $this->appendModelName($field);
            
            if (!isset($filter['value'])) {
                $query [] = "{$field} {$operator}";
                continue;
            }
            
            if (in_array($operator, ['between', 'not between'], true)) {
                $values = [
                    $getValue('value'),
                    $getValue('value'),
                ];
                
                // force min first max last
                $valuesIndex = $filter['value'][0] <= $filter['value'][1] ? 0 : 1;
                
                $bind[$values[0]] = $filter['value'][$valuesIndex ? 1 : 0];
                $bind[$values[1]] = $filter['value'][$valuesIndex ? 0 : 1];
                
                $bindTypes[$values[0]] = Column::BIND_PARAM_STR;
                $bindTypes[$values[1]] = Column::BIND_PARAM_STR;
                
                $not = (str_starts_with($operator, 'not ') ? 'not ' : '');
                $query [] = "{$not}{$field} between :{$values[0]}: and :{$values[1]}:";
                continue;
            }
            
            $distanceOperators = [
                'distance sphere equals',
                'distance sphere greater than',
                'distance sphere greater than or equal',
                'distance sphere less than',
                'distance sphere less than or equal',
            ];
            if (in_array($operator, $distanceOperators, true)) {
                $values = [
                    $getValue('value'),
                    $getValue('value'),
                    $getValue('value'),
                    $getValue('value'),
                ];
                
                $bind[$values[0]] = $filter['value'][0];
                $bind[$values[1]] = $filter['value'][1];
                $bind[$values[2]] = $filter['value'][2];
                $bind[$values[3]] = $filter['value'][3];
                
                $bindTypes[$values[0]] = Column::BIND_PARAM_DECIMAL;
                $bindTypes[$values[1]] = Column::BIND_PARAM_DECIMAL;
                $bindTypes[$values[2]] = Column::BIND_PARAM_DECIMAL;
                $bindTypes[$values[3]] = Column::BIND_PARAM_DECIMAL;
                
                // Prepare values binding of 2 sphere point to calculate distance
                $bitwise =
                    (str_contains($operator, 'greater') ? '>' : '') .
                    (str_contains($operator, 'less') ? '<' : '') .
                    (str_contains($operator, 'equal') ? '=' : '');
                
                $bind[$value] = $filter['value'];
                $bindTypes[$value] = Column::BIND_PARAM_STR;
                $query [] = "ST_Distance_Sphere(point(:{$values[0]}:, :{$values[1]}:), point(:{$values[2]}:, :{$values[3]}:)) $bitwise :{$value}:";
                continue;
            }
            
            if (in_array($operator, ['in', 'not in'], true)) {
                $bind[$value] = $filter['value'];
                $bindTypes[$value] = Column::BIND_PARAM_STR;
                $query [] = "{$field} {$operator} ({{$value}:array})";
                continue;
            }
            
            $queryAndOr = [];
            
            $valueList = is_array($filter['value']) ? $filter['value'] : [$filter['value']];
            foreach ($valueList as $rawValue) {
                $value = $getValue($value);
                
                if (in_array($operator, ['contains', 'does not contain'])) {
                    $bind[$value] = '%' . $rawValue . '%';
                    $bindTypes[$value] = Column::BIND_PARAM_STR;
                    $operator = str_starts_with($operator, 'does not') ? 'not like' : 'like';
                    $queryAndOr [] = "{$field} {$operator} :{$value}:";
                    continue;
                }
                
                if (in_array($operator, ['starts with', 'does not start with'])) {
                    $bind[$value] = $rawValue . '%';
                    $bindTypes[$value] = Column::BIND_PARAM_STR;
                    $operator = str_starts_with($operator, 'does not') ? 'not like' : 'like';
                    $queryAndOr [] = "{$field} {$operator} :{$value}:";
                    continue;
                }
                
                if (in_array($operator, ['ends with', 'does not end with'])) {
                    $bind[$value] = '%' . $rawValue;
                    $bindTypes[$value] = Column::BIND_PARAM_STR;
                    $operator = str_starts_with($operator, 'does not') ? 'not like' : 'like';
                    $queryAndOr [] = "{$field} {$operator} :{$value}:";
                    continue;
                }
                
                if (in_array($operator, ['is empty', 'is not empty'])) {
                    $not = str_starts_with($operator, 'is not') ? '!' : '';
                    $queryAndOr [] = "{$not}(TRIM(:{$field}:) = '' or :{$field}: is null)";
                    continue;
                }
                
                if (in_array($operator, ['regexp', 'not regexp'])) {
                    $bind[$value] = $rawValue;
                    $queryAndOr [] = "{$operator}({$field}, :{$value}:)";
                    continue;
                }
                
                if (in_array($operator, ['contains word', 'does not contain word'])) {
                    $bind[$value] = '\\b' . $rawValue . '\\b';
                    $operator = str_replace(['contains word', 'does not contain word'], ['regexp', 'not regexp'], $operator);
                    $queryAndOr [] = "{$operator}({$field}, :{$value}:)";
                    continue;
                }
                
                $bind[$value] = $rawValue;
                $bindTypes[$value] = $this->getBindTypeFromRawValue($rawValue);
                $queryAndOr [] = "{$field} {$operator} " . (is_array($rawValue) ? "({{$value}:array})" : ":{$value}:");
            }
            
            if (!empty($queryAndOr)) {
                $andOr = str_contains($operator, ' not ') ? 'and' : 'or';
                $query [] = '((' . implode(') ' . $andOr . ' (', $queryAndOr) . '))';
            }
        }
        
        return empty($query) ? null : [
            '(' . implode($or ? ' or ' : ' and ', $query) . ')',
            $bind,
            $bindTypes,
        ];
    }
    
    /**
     * Retrieves the equivalent filter operator for the specified alias or operator.
     *
     * @param string $operator The alias or operator for the filter.
     *
     * @return string The equivalent filter operator, or an empty string if the operator is not allowed.
     */
    public function getFilterOperator(string $operator): string
    {
        $mapAlias = [
            'equals' => '=',
            'not equal' => '!=',
            'does not equal' => '!=',
            'different than' => '<>',
            'greater than' => '>',
            'greater than or equal' => '>=',
            'less than' => '<',
            'less than or equal' => '<=',
            'null-safe equal' => '<=>',
        ];
        
        $allowedOperators = [
            // Native
            '=', // Equal operator
            '!=', // Not equal operator
            '<>', // Not equal operator
            '>', // Greater than operator
            '>=', // Greater than or equal operator
            '<', // Less than or equal operator
            '<=', // Less than or equal operator
            '<=>', // NULL-safe equal to operator
            'in', // Whether a value is within a set of values
            'not in', // Whether a value is not within a set of values
            'like', // Simple pattern matching
            'not like', // Negation of simple pattern matching
            'between', // Whether a value is within a range of values
            'not between', // Whether a value is not within a range of values
            'is', // Test a value against a boolean
            'is not', // Test a value against a boolean
            'is null', // NULL value test
            'is not null', // NOT NULL value test
            'is false', // Test a value against a boolean
            'is not false', // // Test a value against a boolean
            'is true', // // Test a value against a boolean
            'is not true', // // Test a value against a boolean
            
            // Advanced
            'start with',
            'does not start with',
            'end with',
            'does not end with',
            'regexp',
            'not regexp',
            'contains',
            'does not contain',
            'contains word',
            'does not contain word',
            'distance sphere greater than',
            'distance sphere greater than or equal',
            'distance sphere less than',
            'distance sphere less than or equal',
            'is empty',
            'is not empty',
        ];
        
        $operator = $mapAlias[$operator] ?? $operator;
        
        return in_array($operator, $allowedOperators) ? $operator : '';
    }
    
    /**
     * Retrieves the bind type based on the raw value.
     *
     * @param mixed|null $rawValue The raw value to determine the bind type for.
     *
     * @return int The bind type based on the raw value. Possible values are:
     *             - Column::BIND_PARAM_STR: If the raw value is a string or an array.
     *             - Column::BIND_PARAM_INT: If the raw value is an integer.
     *             - Column::BIND_PARAM_BOOL: If the raw value is a boolean.
     *             - Column::BIND_PARAM_DECIMAL: If the raw value is a float or a double.
     *             - Column::BIND_PARAM_NULL: If the raw value is null or its type is not recognized.
     */
    public function getBindTypeFromRawValue(mixed $rawValue = null): int
    {
        if (is_string($rawValue)) {
            return Column::BIND_PARAM_STR;
        }
        
        if (is_int($rawValue)) {
            return Column::BIND_PARAM_INT;
        }
        
        if (is_bool($rawValue)) {
            return Column::BIND_PARAM_BOOL;
        }
        
        // identical to is_float
//        if (is_double($rawValue)) {
//            return Column::BIND_PARAM_DECIMAL;
//        }
        
        if (is_float($rawValue)) {
            return Column::BIND_PARAM_DECIMAL;
        }
        
        if (is_array($rawValue)) {
            return Column::BIND_PARAM_STR;
        }
        
        return Column::BIND_PARAM_NULL;
    }
    
    /**
     * Determines if the specified field is allowed as a filter based on the provided allowed filters.
     *
     * @param string $field The field name to check against the allowed filters.
     * @param array|null $allowedFilters The array of allowed filters or null if no filters are provided.
     *
     * @return bool True if the field is allowed as a filter, false otherwise.
     */
    public function isFilterAllowed(string $field, ?array $allowedFilters): bool
    {
        if (empty($allowedFilters)) {
            return false;
        }
        
        $flat = FlattenKeys::process($allowedFilters);
        return in_array($field, $allowedFilters, true) || !empty($flat[$field]);
    }
    
    /**
     * Check whether the current request filters contain one or more of the specified fields.
     *
     * Supports nested AND/OR logic - each nested array inverts the operator.
     *
     * Examples:
     *   hasFiltersParams('status')                      // checks if "status" filter exists
     *   hasFiltersParams(['status', 'type'], true)      // "status" OR "type"
     *   hasFiltersParams(['status', 'type'])            // "status" AND "type"
     *   hasFiltersParams([['status', 'type']])          // "status" OR "type"
     *   hasFiltersParams([[['status', 'type']]])        // "status" AND "type"
     *
     * @param array|string|null $fields List of fields to check against. If null, checks if "filters" param exists.
     * @param bool $or If true, matches at least one (OR). If false, matches all (AND).
     *
     * @return bool True if the filters satisfy the condition, false otherwise.
     *
     * @throws Exception
     */
    public function hasFiltersFieldsParams(array|string|null $fields = null, bool $or = false): bool
    {
        // no filters param
        if (!$this->hasParam('filters')) {
            return false;
        }
        
        $filters = $this->getParam('filters');
        if (empty($filters)) {
            return false;
        }
        
        // if no fields specified, just check presence of filters param
        if (is_null($fields)) {
            return true;
        }
        
        // normalize to array
        $fields = (array)$fields;
        
        // collect all filter fields recursively
        $flattenFilters = static function (array $filters) use (&$flattenFilters): array {
            $found = [];
            foreach ($filters as $filter) {
                // handle nested groups
                if (isset($filter[0]) && is_array($filter[0])) {
                    $found = array_merge($found, $flattenFilters($filter));
                    continue;
                }
                
                if (!empty($filter['field'])) {
                    $found[] = $filter['field'];
                }
            }
            return $found;
        };
        
        // helper for nested evaluation (similar to has())
        $nestedCheck = function (array|string|null $needles, array $filters, bool $or) use (&$nestedCheck, &$flattenFilters): bool {
            if (!is_array($needles)) {
                $needles = isset($needles) ? [$needles] : [];
            }
            if (empty($needles)) {
                return false;
            }
            
            $filterFields = $flattenFilters($filters);
            $result = [];
            
            foreach ($needles as $needle) {
                if (is_array($needle)) {
                    $result[] = $nestedCheck($needle, $filters, !$or);
                } else {
                    $result[] = in_array($needle, $filterFields, true);
                }
            }
            
            // logical inversion rule
            return $or
                ? in_array(true, $result, true) // OR
                : !in_array(false, $result, true); // AND
        };
        
        return $nestedCheck($fields, $filters, $or);
    }
}
