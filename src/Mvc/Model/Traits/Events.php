<?php

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
     * @param mixed $parameters Optional conditions to filter the retrieved records. Can include arrays, strings, or other query parameters.
     * @return Resultset|Simple|array Returns the result set as an array, a Resultset object, or a Simple object depending on the query execution.
     */
    public static function find(mixed $parameters = null): Resultset|Simple|array
    {
        $ret = self::fireEventCancelCall(__FUNCTION__, func_get_args());
        
        if ($ret !== false) {
            return $ret;
        }
        
        $instance = self::loadInstance();
        $columnMap = $instance->getModelsMetaData()->getColumnMap($instance);
        return new Simple($columnMap, $instance, false);
    }
    
    /**
     * Finds the first record that matches the given parameters.
     *
     * @see \Phalcon\Mvc\Model::findFirst()
     * @param array|string|int|null $parameters Optional parameters to filter the query.
     * @return static|null|false The first matching record, or null if no record is found or false if the operation is canceled.
     */
    public static function findFirst(mixed $parameters = null): mixed
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * Counts the number of records that match the given parameters.
     *
     * This method wraps the core static `count` model call with beforeCount/afterCount cancellable events.
     * The "beforeCount" event can cancel the operation by returning false.
     *
     * @see \Phalcon\Mvc\Model::count()
     * @param array|string|int|null $parameters Optional parameters to filter the count operation.
     * @return ResultsetInterface|int|false The count result or a ResultsetInterface, depending on the implementation.
     */
    public static function count(mixed $parameters = null): ResultsetInterface|int|false
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * Executes a sum operation on the underlying data with optional parameters.
     * This method supports cancellable events triggered before and after execution.
     * If the "beforeSum" event cancels the operation, this method returns false.
     *
     * @see \Phalcon\Mvc\Model::sum()
     * @param mixed $parameters Optional parameters to customize the sum operation.
     * @return ResultsetInterface|float|false Returns the sum result as a float, a result set interface, or false if the operation is canceled.
     */
    public static function sum(mixed $parameters = null): ResultsetInterface|float|false
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
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
     * @param array<int, mixed> $parameters Parameters to define the criteria for calculating the average.
     * @return ResultsetInterface|float|false The calculated average or a ResultsetInterface, depending on the implementation.
     */
    public static function average(array $parameters = []): ResultsetInterface|float|false
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * Wraps core static model calls (find, findFirst, count, sum, average)
     * with beforeX/afterX cancellable events.
     *
     * Example (beforeX/afterX events):
     * - beforeAverage()
     * - beforeSum()
     * - beforeCount()
     * - beforeFind()
     * - beforeFindFirst()
     * - afterAverage()
     * - afterSum()
     * - afterCount()
     * - afterFind()
     * - afterFindFirst()
     *
     * Returns false if the "beforeX" event cancels the operation.
     *
     * @param string $method
     * @param array<int, mixed> $arguments
     * @return mixed
     */
    public static function fireEventCancelCall(string $method, array $arguments = []): mixed
    {
        $instance = self::loadInstance();
        $event = ucfirst(Helper::camelize($method));
        
        if ($instance->fireEventCancel('before' . $event) === false) {
            return false;
        }
        
        $ret = parent::$method(...$arguments);
        
        $instance->fireEvent('after' . $event);
        
        return $ret;
    }
}
