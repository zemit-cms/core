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
use Phalcon\Text;

trait Events
{
    /**
     * @return ResultsetInterface|bool
     */
    public static function find(array ...$arguments): ResultsetInterface
    {
        return self::fireEventCancelCall(__FUNCTION__, $arguments);
    }

    /**
     * @return ResultsetInterface|bool
     */
    public static function findFirst(array ...$arguments)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }

    /**
     * @return ResultsetInterface|int|false
     */
    public static function count(array ...$arguments)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }

    /**
     * @return ResultsetInterface|float|false
     */
    public static function sum(array ...$arguments)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    /**
     * @return ResultsetInterface|float|false
     */
    public static function average(array ...$arguments)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }

    /**
     * Call the before & after events
     * @return mixed|false
     */
    public static function fireEventCancelCall(string $method, array $arguments = [])
    {
        $class = get_called_class();
        $that = new $class();
        $event = ucfirst(Text::camelize($method));
        
        if ($that->fireEventCancel('before' . $event) === false) {
            return false;
        }

        $ret = parent::$method(...$arguments);
        
        $that->fireEvent('after' . $event);
        
        return $ret;
    }
}
