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

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\Model\Row;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractInstance;
use Zemit\Support\Helper;

trait Events
{
    use AbstractInstance;
    
    abstract public function fireEventCancel(string $eventName): bool;
    
    /**
     * Retrieves records from the database that match the specified conditions.
     *
     * @see \Phalcon\Mvc\Model::find()
     * @param array|int|null|string $parameters Optional conditions to filter the retrieved records. Can include arrays, strings, or other query parameters.
     * @return Resultset|array Returns the result set as an array, a Resultset object, or a Simple object depending on the query execution.
     */
    #[\Override]
    public static function find(mixed $parameters = null): Resultset|array
    {
        return self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::find($parameters)) ?: [];
    }
    
    /**
     * Finds the first record that matches the given parameters.
     *
     * @see \Phalcon\Mvc\Model::findFirst()
     * @param array|int|null|string $parameters Optional parameters to filter the query.
     * @return ModelInterface|Row|false|null The first matching record, or null if no record is found or false if the operation is canceled.
     */
    #[\Override]
    public static function findFirst(mixed $parameters = null): ModelInterface|Row|false|null
    {
        return self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::findFirst($parameters));
    }
    
    /**
     * Counts the number of records that match the given parameters.
     *
     * This method wraps the core static `count` model call with beforeCount/afterCount cancellable events.
     * The "beforeCount" event can cancel the operation by returning false.
     *
     * @see \Phalcon\Mvc\Model::count()
     * @param array|null|string $parameters Optional parameters to filter the count operation.
     * @return ResultsetInterface|int|false The count result or a ResultsetInterface, depending on the implementation.
     */
    #[\Override]
    public static function count(mixed $parameters = null): ResultsetInterface|int|false
    {
        $count = self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::count($parameters));
        
        if (is_string($count)) {
            return (int)$count;
        }
        
        return $count;
    }
    
    /**
     * Executes a sum operation on the underlying data with optional parameters.
     * This method supports cancellable events triggered before and after execution.
     * If the "beforeSum" event cancels the operation, this method returns false.
     *
     * @see \Phalcon\Mvc\Model::sum()
     * @param array $parameters Optional parameters to customize the sum operation.
     * @return ResultsetInterface|float|false Returns the sum result as a float, a result set interface, or false if the operation is canceled.
     */
    #[\Override]
    public static function sum(mixed $parameters = []): ResultsetInterface|float|false
    {
        $sum = self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::sum($parameters));
        
        if (is_string($sum)) {
            return floatval($sum);
        }
        
        return $sum;
    }
    
    /**
     * Calculates the average of results based on the provided parameters. It wraps the method execution
     * with before/after cancellable events.
     *
     * Example events triggered:
     * - beforeAverage()
     * - afterAverage()
     *
     * If the "beforeAverage" event cancels the operation, false is returned.
     * @see \Phalcon\Mvc\Model::average()
     * @param array $parameters Parameters to define the criteria for calculating the average.
     * @return ResultsetInterface|float|false The calculated average or a ResultsetInterface, depending on the implementation.
     */
    #[\Override]
    public static function average(array $parameters = []): ResultsetInterface|float|false
    {
        $average = self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::average($parameters));
        
        if (is_string($average)) {
            return (float)$average;
        }
        
        return $average;
    }
    
    /**
     * Calculates the minimum value of a specified column in the database according to the given conditions.
     *
     * @param array $parameters Parameters to customize the query, such as conditions, column selection, or groupings.
     * @return ResultsetInterface|float|false Returns the minimum value as a float, a ResultsetInterface object, or false if no matching records are found or the operation fails.
     */
    #[\Override]
    public static function minimum(mixed $parameters = []): ResultsetInterface|float|false
    {
        $minimum = self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::minimum($parameters));
        
        if (is_string($minimum)) {
            return (float)$minimum;
        }
        
        return $minimum;
    }
    
    /**
     * Calculates the maximum value of a specified column in the database based on the given conditions.
     *
     * @param array $parameters Parameters to customize the query, such as conditions, column selection, or groupings.
     * @return ResultsetInterface|float|false Returns the computed maximum value as a float, a ResultsetInterface object for detailed results, or false on failure.
     */
    #[\Override]
    public static function maximum(mixed $parameters = []): ResultsetInterface|float|false
    {
        $maximum = self::fireEventCancelCall(__FUNCTION__, fn(): mixed => parent::maximum($parameters));
        
        if (is_string($maximum)) {
            return (float)$maximum;
        }
        
        return $maximum;
    }
    
    /**
     *  Wraps core static model calls (find, findFirst, count, sum, average, minimum, maximum)
     *  with beforeX/afterX cancellable events.
     *
     *  Example (beforeX/afterX events):
     *  - beforeAverage()
     *  - beforeSum()
     *  - beforeCount()
     *  - beforeFind()
     *  - beforeFindFirst()
     *  - afterAverage()
     *  - afterSum()
     *  - afterCount()
     *  - afterFind()
     *  - afterFindFirst()
     *
     *  Returns false if the "beforeX" event cancels the operation.
     *
     * @param string $method
     * @param callable $callable
     * @return mixed
     */
    public static function fireEventCancelCall(string $method, callable $callable): mixed
    {
        $instance = self::loadInstance();
        $event = ucfirst(Helper::camelize($method));
        
        if ($instance->fireEventCancel('before' . $event) === false) {
            return false;
        }
        
        $ret = $callable();
        
        $instance->fireEvent('after' . $event);
        
        return $ret;
    }
}
