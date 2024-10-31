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

use JetBrains\PhpStorm\Deprecated;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\EagerLoading\Loader;

trait EagerLoad
{
    abstract public static function find($parameters = null);
    
    abstract public static function findFirst($parameters = null);
    
    /**
     * <code>
     * <?php
     *
     * $limit  = 100;
     * $offset = max(0, $this->request->getQuery('page', 'int') - 1) * $limit;
     *
     * $manufacturers = Manufacturer::with('Robots.Parts', [
     *     'limit' => [$limit, $offset]
     * ]);
     *
     * foreach ($manufacturers as $manufacturer) {
     *     foreach ($manufacturer->robots as $robot) {
     *         foreach ($robot->parts as $part) { ... }
     *     }
     * }
     *
     * </code>
     *
     * @param array ...$arguments
     */
    public static function findWith(array ...$arguments): array
    {
        $parameters = self::getParametersFromArguments($arguments);
        $list = static::find($parameters);
        
        if (is_countable($list) && $list->count()) {
            return Loader::fromResultset($list, ...$arguments);
        }
        
        return [];
    }
    
    /**
     * Same as EagerLoadingTrait::findWith() for a single record
     *
     * @param array ...$arguments
     * @return ?ModelInterface
     */
    public static function findFirstWith(array ...$arguments): ?ModelInterface
    {
        $parameters = self::getParametersFromArguments($arguments);
        $entity = static::findFirst($parameters);
        
        if ($entity instanceof ModelInterface) {
            return Loader::fromModel($entity, ...$arguments);
        }
        
        return null;
    }
    
    /**
     * @deprecated
     * @link self::findWith()
     */
    #[Deprecated(
        reason: 'since Zemit 1.0, use findWith() instead',
        replacement: '%class%::findWith(%parametersList%)'
    )]
    public static function with(array ...$arguments)
    {
        return self::findWith(...$arguments);
    }
    
    /**
     * @deprecated
     * @link self::findFirstWith()
     */
    #[Deprecated(
        reason: 'since Zemit 1.0, use findFirstWith() instead',
        replacement: '%class%::findFirstWith(%parametersList%)'
    )]
    public static function firstWith(array ...$arguments)
    {
        return self::findWith(...$arguments);
    }
    
    /**
     * Call magic method to make the with works in an implicit way
     * @todo change it to behavior missingMethods()
     */
    public static function __callStatic(string $method, array $arguments = [])
    {
        // Single - FindFirstBy...
        if (strpos($method, 'findFirstWithBy') === 0 || strpos($method, 'firstWithBy') === 0) {
            
            $forwardMethod = str_replace(['findFirstWithBy', 'firstWithBy'], 'findFirstBy', $method);
            return self::findFirstWithBy($forwardMethod, $arguments);
        }
        
        // List - FindWithBy...
        elseif (strpos($method, 'findWithBy') === 0 || strpos($method, 'withBy') === 0) {
    
            $forwardMethod = str_replace(['findWithBy', 'withBy'], 'findBy', $method);
            return self::findWithBy($forwardMethod, $arguments);
        }
    
        return @parent::$method(...$arguments); // @todo refactor for php83+
    }
    
    /**
     * Call native Phalcon FindFirstBy function then eager load relationships from the model
     */
    private static function findFirstWithBy(string $forwardMethod, array $arguments): ?ModelInterface
    {
        $parameters = self::getParametersFromArguments($arguments);
        $entity = @parent::$forwardMethod($parameters); // @todo refactor for php83+
    
        if ($entity instanceof ModelInterface) {
            return Loader::fromModel($entity, ...$arguments);
        }
    
        return null;
    }
    
    /**
     * Call native Phalcon findBy function then eager load relationships from the resultset
     */
    private static function findWithBy(string $forwardMethod, array $arguments): ?array
    {
        $parameters = self::getParametersFromArguments($arguments);
        $list = parent::$forwardMethod($parameters);
        assert($list instanceof ResultsetInterface);
        
        if (is_countable($list) && $list->count()) {
            return Loader::fromResultset($list, ...$arguments);
        }
    
        return [];
    }
    
    /**
     * <code>
     *
     * $manufacturer = Manufacturer::findFirstById(51);
     *
     * $manufacturer->load('Robots.Parts');
     *
     * foreach ($manufacturer->robots as $robot) {
     *    foreach ($robot->parts as $part) { ... }
     * }
     *
     * </code>
     *
     * @param array ...$arguments
     * @return ?ModelInterface
     */
    public function load(array ...$arguments): ?ModelInterface
    {
        assert($this instanceof ModelInterface);
        return Loader::fromModel($this, ...$arguments);
    }
    
    /**
     * Get the query parameters from a list of arguments
     * @return mixed
     */
    public static function getParametersFromArguments(array &$arguments)
    {
        $parameters = null;
        
        if (!empty($arguments)) {
            $numArgs = count($arguments);
            $lastArg = $numArgs - 1;
            
            if ($numArgs >= 2) {
                $parameters = $arguments[$lastArg];
                unset($arguments[$lastArg]);
                
                if (isset($parameters['columns'])) {
//                    throw new \LogicException('Results from database must be full models, do not use `columns` key'); // removed to allow where or having conditions on dynamic columns
                    // the first columns should be * so we can have the main model and all the necessary fields for eager loading
                    if ($parameters['columns'][0] !== '*') {
                        array_unshift($parameters['columns'], '*');
                    }
                }
            }
        }
        
        return $parameters;
    }
}
