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

use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Support\Helper;

trait Events
{
    abstract public function fireEventCancel(string $eventName): bool;
    
    public static function find($parameters = null)
    {
        $ret = self::fireEventCancelCall(__FUNCTION__, func_get_args());
        
        if (!$ret) {
            $that = new self();
            assert($that instanceof ModelInterface);
            $columnMap = $that->getModelsMetaData()->getColumnMap($that);
            return new Simple($columnMap, $that, false);
        }
        
        return $ret;
    }

    public static function findFirst($parameters = null)
    {
        $ret = self::fireEventCancelCall(__FUNCTION__, func_get_args());
        return $ret ?: null;
    }

    public static function count($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }

    public static function sum($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }
    
    public static function average($parameters = null)
    {
        return self::fireEventCancelCall(__FUNCTION__, func_get_args());
    }

    public static function fireEventCancelCall(string $method, array $arguments = [])
    {
        $class = get_called_class();
        $that = new $class();
        $event = ucfirst(Helper::camelize($method));
        
        if ($that->fireEventCancel('before' . $event) === false) {
            return false;
        }

        $ret = @parent::$method(...$arguments); // @todo fix this for php 83+
        
        $that->fireEvent('after' . $event);
        
        return $ret;
    }
}
