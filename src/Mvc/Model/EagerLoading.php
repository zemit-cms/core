<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Zemit\Mvc\Model\EagerLoading\Loader;

trait EagerLoading
{
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
     * @param mixed ...$arguments
     */
    public static function findWith(array ...$arguments)
    {
        $parameters = self::getParametersFromArguments($arguments);
        $list = static::find($parameters);
        if ($list->count()) {
            return Loader::fromResultset($list, ...$arguments);
        }
        
        return $list;
    }
    
    /**
     * Same as EagerLoadingTrait::findWith() for a single record
     *
     * @param mixed ...$arguments
     * @return false|\Phalcon\Mvc\ModelInterface
     */
    public static function findFirstWith(array ...$arguments)
    {
        $parameters = self::getParametersFromArguments($arguments);
        $entity = static::findFirst($parameters);
        if ($entity) {
            return Loader::fromModel($entity, ...$arguments);
        }
        
        return $entity;
    }
    
    /**
     * @deprecated
     * Alias of findWith
     */
    public static function with(array ...$arguments)
    {
        return self::findWith(...$arguments);
    }
    
    /**
     * @deprecated
     * Alias of findWith
     */
    public static function firstWith(array ...$arguments)
    {
        return self::findWith(...$arguments);
    }
    
    /**
     * Call magic method to make the with works in an implicit way
     * @todo change it to behavior missingMethods()
     * @todo change it
     */
    public static function __callStatic(string $method, array $arguments = [])
    {
        // Single - FindFirstBy...
        if (strpos($method, 'findFirstWithBy') === 0 || strpos($method, 'firstWithBy') === 0) {
            
            $forwardMethod = str_replace(['findFirstWithBy', 'firstWithBy'], 'findFirstBy', $method);
            $parameters = self::getParametersFromArguments($arguments);
            $entity = parent::$forwardMethod($parameters);
            
            if ($entity) {
                return Loader::fromModel($entity, ...$arguments);
            }
            
            return $entity;
        }
        
        // List - FindWithBy...
        elseif (strpos($method, 'findWithBy') === 0 || strpos($method, 'withBy') === 0) {
            
            $forwardMethod = str_replace(['findWithBy', 'withBy'], 'findBy', $method);
            $parameters = self::getParametersFromArguments($arguments);
            $list = parent::$forwardMethod($parameters);
            
            if ($list->count()) {
                return Loader::fromResultset($list, ...$arguments);
            }
            
            return $list;
        }
    
        return parent::$method(...$arguments);
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
     * @param mixed ...$arguments
     * @return \Phalcon\Mvc\ModelInterface
     */
    public function load(array ...$arguments)
    {
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
                    throw new \LogicException('Results from database must be full models, do not use `columns` key');
                }
            }
        }
        
        return $parameters;
    }
}
