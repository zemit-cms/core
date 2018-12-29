<?php

namespace Zemit\Mvc\Model;

//use Phalcon\Db\Column;

/**
 * Class Eagerload
 *
 * Overriding EagerLoadingTrait from the phalcon incubator to handle more type of requests
 * - Allow to call the "with" and "findfirstWith" without passing an argument
 * - Adding the default phalcon call static behavior to the "with" and "findFirstWith"
 *  - findFirstWithBy{Property}()
 *  - withBy{Property}()
 *  - every other magic call statics that may exists
 *
 * @author Zemit@nuagerie.com
 * @package Zemit\Mvc\Model
 */
trait Eagerload
{
    
    // forked from the phalcon incubator
    use \Zemit\Mvc\Model\EagerLoadingTrait {
        with as incubatorWith;
        findFirstWith as incubatorFindFirstWith;
    }
    
    // expose @todo check why i put it here...
    use Expose\Expose;
    
    
    public static function with() {
        $arguments = func_get_args();
        try {
            $retval = forward_static_call_array('self::incubatorWith', $arguments);
        } catch(\BadMethodCallException $e) {
            
            // overriding the bad method call exception to work anyway
            $parameters = self::_prepareParameters($arguments);
            $retval = static::find($parameters);
            if (isset($retval[0]) && count($retval)) {
                array_unshift($arguments, $retval);
//                $retval = call_user_func_array('Phalcon\Mvc\Model\EagerLoading\Loader::fromResultset', $arguments);
                $retval = call_user_func_array('Zemit\Mvc\Model\EagerLoading\Loader::fromResultset', $arguments);
            } else {
                $retval = array();
            }
        }
        return $retval;
    }
    
    public static function findFirstWith() {
        $arguments = func_get_args();
        try {
            $retval = forward_static_call_array('self::incubatorFindFirstWith', $arguments);
        } catch(\BadMethodCallException $e) {
            
            // overriding the bad method call exception to work anyway
            $parameters = self::_prepareParameters($arguments);
            if ($retval = static::findFirst($parameters)) {
                array_unshift($arguments, $retval);
//                $retval = call_user_func_array('Phalcon\Mvc\Model\EagerLoading\Loader::fromModel', $arguments);
                $retval = call_user_func_array('Zemit\Mvc\Model\EagerLoading\Loader::fromModel', $arguments);
            }
        }
        return $retval;
    }
    
    
    /**
     * Call magic method to make the with works in an implicit way
     *
     * @param string $method
     * @param object|array $arguments
     *
     * @return Phalcon\Mvc\Model\Resultset
     */
    public static function __callStatic($method, $arguments = array())
    {
        if (strpos($method, 'findFirstWith') === 0) {
            $oriMethod = str_replace('findFirstWith', 'findFirst', $method);
            $entity = parent::__callStatic($oriMethod, [self::_getParameters($arguments)]);
            if ($entity) {
                $entity->load(array_pop($arguments));
            }
            return $entity;
        } elseif (strpos($method, 'findWith') === 0 || strpos($method, 'withBy') === 0) {
            $oriMethod = str_replace(['findWith', 'withBy'], ['find', 'findBy'], $method);
            $retval = parent::__callStatic($oriMethod, [self::_getParameters($arguments)]);
            if (isset($retval[0]) && count($retval)) {
                array_unshift($arguments, $retval);
                $retval = call_user_func_array('Zemit\Mvc\Model\EagerLoading\Loader::fromResultset', $arguments);
            } else {
                $retval = array();
            }
            return $retval;
        } else {
            return parent::__callStatic($method, $arguments);
        }
    }
    
    private static function _getParameters(&$arguments)
    {
        return array_pop($arguments);
    }
    
    private static function _prepareParameters(&$arguments) {
        
        $parameters = null;
        if (!empty($arguments)) {
            $numArgs = count($arguments);
            $lastArg = $numArgs - 1;
            
            if ($numArgs >= 2 && is_array($arguments[$lastArg])) {
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
