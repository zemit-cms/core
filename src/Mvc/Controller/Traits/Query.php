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

namespace Zemit\Mvc\Controller\Traits;

use Phalcon\Filter\Exception;
use Phalcon\Support\Collection;
use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Query\Bind;
use Zemit\Mvc\Controller\Traits\Query\Cache;
use Zemit\Mvc\Controller\Traits\Query\Column;
use Zemit\Mvc\Controller\Traits\Query\Conditions;
use Zemit\Mvc\Controller\Traits\Query\Distinct;
use Zemit\Mvc\Controller\Traits\Query\Fields;
use Zemit\Mvc\Controller\Traits\Query\Group;
use Zemit\Mvc\Controller\Traits\Query\Having;
use Zemit\Mvc\Controller\Traits\Query\Joins;
use Zemit\Mvc\Controller\Traits\Query\Limit;
use Zemit\Mvc\Controller\Traits\Query\Offset;
use Zemit\Mvc\Controller\Traits\Query\Order;
use Zemit\Mvc\Controller\Traits\Query\Save;
use Zemit\Mvc\Controller\Traits\Query\With;
use Zemit\Mvc\Model\Interfaces\EagerLoadInterface;

/**
 * Class Query
 *
 * This class provides methods for building and executing database queries.
 * It is used as a trait in other classes that need query building capabilities.
 */
trait Query
{
    use AbstractQuery;
    
    use AbstractModel;
    
    use Bind;
    use Cache;
    use Column;
    use Conditions;
    use Distinct;
    use Fields;
    use Group;
    use Having;
    use Joins;
    use Limit;
    use Offset;
    use Order;
    use Save;
    use With;
    
    protected ?Collection $find = null;
    
    /**
     * Initializes the query builder with default values for various properties.
     *
     * @throws Exception
     * @throws \Exception
     */
    public function initializeQuery(): void
    {
        $this->eventsManager->fire('rest:beforeInitializeQuery', $this);
        
        $this->initializeCacheConfig();
        $this->eventsManager->fire('rest:afterInitializeCacheConfig', $this);
        
        $this->initializeFields();
        $this->eventsManager->fire('rest:afterInitializeFields', $this);
        
        $this->initializeBind();
        $this->eventsManager->fire('rest:afterInitializeBind', $this);
        
        $this->initializeBindTypes();
        $this->eventsManager->fire('rest:afterInitializeBindTypes', $this);
        
        $this->initializeConditions();
        $this->eventsManager->fire('rest:afterInitializeConditions', $this);
        
        $this->initializeDistinct();
        $this->eventsManager->fire('rest:afterInitializeDistinct', $this);
        
        $this->initializeGroup();
        $this->eventsManager->fire('rest:afterInitializeGroup', $this);
        
        $this->initializeHaving();
        $this->eventsManager->fire('rest:afterInitializeHaving', $this);
        
        $this->initializeJoins();
        $this->eventsManager->fire('rest:afterInitializeJoins', $this);
        
        $this->initializeLimit();
        $this->eventsManager->fire('rest:afterInitializeLimit', $this);
        
        $this->initializeOffset();
        $this->eventsManager->fire('rest:afterInitializeOffset', $this);
        
        $this->initializeOrder();
        $this->eventsManager->fire('rest:afterInitializeOrder', $this);
        
//        $this->initializeSave();
//        $this->eventsManager->fire('rest:afterInitializeSave', $this);
        
        $this->initializeWith();
        $this->eventsManager->fire('rest:afterInitializeWith', $this);
        
        $this->initializeFind();
        $this->eventsManager->fire('rest:afterInitializeFind', $this);
        
        $this->eventsManager->fire('rest:afterInitializeQuery', $this);
    }
    
    /**
     * Initializes the `find` property with a new Collection object.
     * The values of various properties are assigned to the corresponding keys of the Collection object.
     *
     * @return void
     */
    public function initializeFind(): void
    {
        $this->setFind(new Collection([
            'conditions' => $this->getConditions(),
            'bind' => $this->getBind(),
            'bindTypes' => $this->getBindTypes(),
            'limit' => $this->getLimit(),
            'offset' => $this->getOffset(),
            'order' => $this->getOrder(),
//            'columns' => $this->getColumns(),
            'distinct' => $this->getDistinct(),
            'joins' => $this->getJoins(),
            'group' => $this->getGroup(),
            'having' => $this->getHaving(),
            'cache' => $this->getCacheConfig(),
        ]));
    }
    
    /**
     * Sets the value of the `find` property.
     *
     * @param Collection|null $find The new value for the `find` property.
     * @return void
     */
    public function setFind(?Collection $find): void
    {
        $this->find = $find;
    }
    
    /**
     * Retrieves the value of the `find` property.
     *
     * @return Collection|null The value of the `find` property.
     */
    public function getFind(): ?Collection
    {
        return $this->find;
    }
    
    /**
     * Builds the `find` array for a query.
     *
     * @param Collection|null $find The collection to build the find array from. Defaults to null.
     * @param bool $ignoreKey Whether to ignore the keys in the collection. Defaults to false.
     * @return array The built find array.
     */
    public function prepareFind(?Collection $find = null, bool $ignoreKey = false): array
    {
        $build = [];
        $find ??= $this->getFind();
        $iterator = $find?->getIterator() ?? [];
        foreach ($iterator as $key => $value) {
            if ($value instanceof Collection) {
                $subIgnoreKey = $ignoreKey || in_array($key, ['conditions', 'joins', 'group', 'order']);
                $sub = $this->prepareFind($value, $subIgnoreKey);
                if ($ignoreKey) {
                    $build = array_merge($build, $sub);
                } else {
                    $build[$key] = $sub;
                }
            } else {
                $build[$key] = $value;
            }
        }
        
        if (isset($build['group']) && is_array($build['group'])) {
            $build['group'] = implode(', ', $build['group']);
        }
        
        return $this->mergeConditions(array_filter($ignoreKey ? array_values($build) : $build));
    }

    /**
     * Merges and reformats the multiple conditions array to work with Phalcon\Mvc\Model\Query\Builder
     *
     * @param array $ret The input array that may contain conditions and other related data.
     * @return array The modified array with merged and reformatted conditions.
     */
    public function mergeConditions(array $ret): array
    {
        $mergedConditions = [];
        if (isset($ret['conditions'])) {
            foreach ($ret['conditions'] as $key => &$condition) {
                foreach ($condition as $k => $v) {
                    if (in_array($k, [1, 2, 'joins', 'group', 'order', 'bind', 'bindTypes'], true) && is_array($v)) {
                        $k = $k === 1 ? 'bind' : ($k === 2 ? 'bindTypes' : $k);
                        $ret[$k] = array_merge($ret[$k] ?? [], $v);
                        unset($condition[$k]);
                    }
                }
                $mergedConditions [] = $condition[0] ?? $condition['conditions'] ?? $condition;
            }
            $mergedConditions = '(' . implode(') AND (', $mergedConditions) . ')';
            $ret[0] = $mergedConditions;
            unset($ret['conditions']);
        }
        
        return $ret;
    }
    
    /**
     * Find records in the database using the specified criteria.
     *
     * @param array|null $find Optional. An array of criteria to determine the records to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used. Defaults to `null`.
     *
     * @return ResultsetInterface The result of the find operation.
     */
    public function find(?array $find = null)
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::find($find);
    }
    
    /**
     * Find records in the database using the specified criteria and include related records.
     *
     * @param array|null $with Optional. An array of related models to include
     *                         with the found records. Defaults to `null`.
     * @param array|null $find Optional. An array of criteria to determine the records to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used. Defaults to `null`.
     *
     * @return array The result of the find operation with loaded relationships.
     */
    public function findWith(?array $with = null, ?array $find = null): array
    {
        $find ??= $this->prepareFind();
        $with ??= $this->getWith()?->toArray() ?? [];
        $model = $this->loadModel();
        assert($model instanceof EagerLoadInterface);
        return $model::findWith($with, $find);
    }
    
    /**
     * Find the first record in the database using the specified criteria.
     *
     * @param array|null $find Optional. An array of criteria to determine the record to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used to find the first record. Defaults to `null`.
     *
     * // @todo \Phalcon\Mvc\ModelInterface|\Phalcon\Mvc\Model\Row|null
     * @return mixed The result of the find operation, which is the first record that matches the criteria.
     */
    public function findFirst(?array $find = null): mixed
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::findFirst($find);
    }
    
    /**
     * Find the first record in the database using the specified criteria and relations.
     *
     * @param array|null $with Optional. An array of relations to eager load for the record.
     *                         If not provided, the default relations from `getWith()` method
     *                         will be used. Defaults to `null`.
     * @param array|null $find Optional. An array of criteria to determine the records to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used. Defaults to `null`.
     *
     * @return mixed The result of the find operation for the first record.
     */
    public function findFirstWith(?array $with = null, ?array $find = null): mixed
    {
        $find ??= $this->prepareFind();
        $with ??= $this->getWith()?->toArray() ?? [];
        $model = $this->loadModel();
        assert($model instanceof EagerLoadInterface);
        return $model::findFirstWith($with, $find);
    }
    
    /**
     * Calculates the average value based on a given set of criteria.
     *
     * @param array|null $find The criteria to filter the records by (optional).
     * @return float|ResultsetInterface The average value or a result set containing the average value.
     */
    public function average(?array $find = null): float|ResultsetInterface
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::average($this->getCalculationFind($find));
    }
    
    /**
     * Retrieves the total count of items based on the specified model name and find criteria.
     * Note: limit and offset are removed from the parameters in order to retrieve the total count
     *
     * @param array|null $find An array of find criteria to filter the results. If null, the default criteria will be applied.
     *
     * @return int|ResultsetInterface The total count of items that match the specified criteria.
     * @throws \Exception
     */
    public function count(?array $find = null): int|ResultsetInterface
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::count($this->getCalculationFind($find));
    }
    
    /**
     * Calculates the sum of values based on a given search criteria.
     *
     * @param array|null $find Optional: The criteria to find the maximum value from.
     *                         Default: null (will retrieve the `find` from $this->getFind())
     *
     * @return float|ResultsetInterface The calculated sum of values.
     */
    public function sum(?array $find = null): float|ResultsetInterface
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::sum($this->getCalculationFind($find));
    }
    
    /**
     * Retrieves the minimum value.
     *
     * @param array|null $find Optional: The criteria to find the maximum value from.
     *                         Default: null (will retrieve the `find` from $this->getFind())
     *
     * @return float|ResultsetInterface The maximum value from the dataset
     *                                  or a `ResultsetInterface` that represents the grouped maximum values.
     */
    public function maximum(?array $find = null): float|ResultsetInterface
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::maximum($this->getCalculationFind($find));
    }
    
    /**
     * Retrieves the minimum value.
     *
     * @param array|null $find Optional: The criteria to find the minimum value from.
     *                         Default: null (will retrieve the `find` from $this->getFind())
     *
     * @return float|ResultsetInterface The minimum value from the dataset
     *                                  or a `ResultsetInterface` that represents the grouped minimum values.
     */
    public function minimum(?array $find = null): float|ResultsetInterface
    {
        $find ??= $this->prepareFind();
        return $this->loadModel()::minimum($this->getCalculationFind($find));
    }
    
    /**
     * Prepares and retrieves the modified `find` array with optional adjustments.
     *
     * @param array|null $find The initial `find` array to modify. If null, it defaults
     *                         to the result of `getFind()->toArray()` or an empty array.
     * @param bool $removeLimitOffset Whether to remove `limit` and `offset` keys
     *                                from the `find` array. Defaults to true.
     * @return array The adjusted `find` array, filtered with any necessary modifications.
     */
    protected function getCalculationFind(?array $find = null, bool $removeLimitOffset = true): array
    {
        $find ??= $this->getFind()?->toArray() ?? [];
        
        // remove limit
        if ($removeLimitOffset) {
            if (isset($find['limit'])) {
                unset($find['limit']);
            }
            
            // remove offset
            if (isset($find['offset'])) {
                unset($find['offset']);
            }
        }
        
        // calculation columns fail when the group is an array, combine it to a string
        if (isset($find['group']) && is_array($find['group'])) {
            $find['group'] = implode(', ', $find['group']);
        }
        
        return array_filter($find);
    }
    
    /**
     * Generates a unique bind key with the given prefix.
     *
     * @param string $prefix The prefix to be used in the bind key.
     *
     * @return string The generated bind key.
     */
    public function generateBindKey(string $prefix): string
    {
        return '_' . uniqid($prefix . '_') . '_';
    }
}
