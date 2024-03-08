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

use Phalcon\Support\Collection;
use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Query\Bind;
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

/**
 * Class Query
 *
 * This class provides methods for building and executing database queries.
 * It is used as a trait in other classes that need query building capabilities.
 */
trait Query
{
    use AbstractModel;
    
    use Bind;
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
    
    protected ?Collection $find;
    
    /**
     * Initializes the query builder with default values for various properties.
     */
    public function initialize() {
        $this->initializeBind();
        $this->initializeConditions();
        $this->initializeDistinct();
        $this->initializeFields();
        $this->initializeGroup();
        $this->initializeHaving();
        $this->initializeJoins();
        $this->initializeLimit();
        $this->initializeOffset();
        $this->initializeOrder();
//        $this->initializeSave();
        $this->initializeWith();
    }
    
    /**
     * Initializes the `find` property with a new Collection object.
     * The values of various properties are assigned to the corresponding keys of the Collection object.
     *
     * @return void
     */
    public function initializeFind(): void
    {
        $this->find = new Collection([
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
            'cache' => $this->getCache(),
        ]);
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
     * Find records in the database using the specified criteria.
     *
     * @param array|null $find Optional. An array of criteria to determine the records to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used. Defaults to `null`.
     *
     * @return mixed The result of the find operation.
     */
    public function find(?array $find = null) {
        $find ??= $this->getFind() ?? [];
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
     * @return mixed The result of the find operation.
     */
    public function findWith(?array $with = null, ?array $find = null) {
        $with ??= $this->getWith() ?? [];
        $find ??= $this->getFind() ?? [];
        return $this->loadModel()::findWith($with, $find);
    }
    
    /**
     * Find the first record in the database using the specified criteria.
     *
     * @param array|null $find Optional. An array of criteria to determine the record to find.
     *                         If not provided, the default criteria from `getFind()` method
     *                         will be used to find the first record. Defaults to `null`.
     *
     * @return mixed The result of the find operation, which is the first record that matches the criteria.
     */
    public function findFirst(?array $find = null) {
        $find ??= $this->getFind() ?? [];
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
    public function findFirstWith(?array $with = null, ?array $find = null) {
        $with ??= $this->getWith() ?? [];
        $find ??= $this->getFind() ?? [];
        return $this->loadModel()::findFirstWith($with, $find);
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
        return $this->loadModel()::minimum($this->getCalculationFind($find));
    }
    
    /**
     * Retrieves the count criteria based on the specified find criteria.
     *
     * @param array|null $find An array of find criteria to filter the results. If null, the default criteria will be used.
     *
     * @return array An array of filtered find criteria without the 'limit' and 'offset' keys.
     */
    protected function getCalculationFind(?array $find = null): array
    {
        $find ??= $this->getFind() ?? [];
        
        if (isset($find['limit'])) {
            unset($find['limit']);
        }
        
        if (isset($find['offset'])) {
            unset($find['offset']);
        }
        
        return array_filter($find);
    }
}
