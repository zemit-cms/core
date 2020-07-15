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

use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Mvc\Model;

trait Events
{
//    /**
//     * @param null $parameters
//     *
//     * @return ResultsetInterface|bool
//     */
//    public static function findIn($parameters = null): ResultsetInterface
//    {
//        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
//    }
    
    /**
     * @param null $parameters
     *
     * @return ResultsetInterface|bool
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * @param null $parameters
     *
     * @return ResultsetInterface|bool
     */
    public static function findFirst($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * @param null $parameters
     *
     * @return ResultsetInterface|bool
     */
    public static function count($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * @param null $parameters
     *
     * @return ResultsetInterface|bool
     */
    public static function sum($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * @param null $parameters
     *
     * @return ResultsetInterface|bool
     */
    public static function average($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * Call the before events
     * - find
     * - findFirst
     * - count
     * - sum
     * - average
     *
     * @param $call
     * @param $params
     *
     * @return bool
     */
    public static function fireEventCancelCall($call, $params) {
        
        $class = get_called_class();
        $that = new $class();
        
        if ($that->fireEventCancel('before' . ucfirst($call)) === false) {
//            throw new \Exception('Not allowed to `' . $call . '` on model `' . get_called_class() . '`');
            return false;
        }
        
        $ret = parent::$call(...$params);
    
        $that->fireEvent('after' . ucfirst($call));
        
        return $ret;
    }
}
