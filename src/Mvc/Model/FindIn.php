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

/**
 * Trait FindIn
 *
 * @package Zemit\Mvc\Model
 */
trait FindIn
{
    /**
     * @param array $keys
     *
     * @return mixed
     */
    public static function findIn(array $keys = [], array $params = [])
    {
        $class = get_called_class();
        $that = new $class();
        $call = __FUNCTION__;
        
        if ($that->fireEventCancel('before' . ucfirst($call)) === false) {
            throw new \Exception('Not allowed to call `' . $call . '` on model `' . $class . '`');
        }
        
        $keys = $keys ? $keys : array(null);
        
        $intFilter = function ($id) {
            return (int) $id;
        };
        $query = self::getPreparedQuery($params);
        foreach ($keys as $key => $ids) {
            $query->inWhere($key, array_map($intFilter, $ids));
        }
        
        return $query->execute();
    }
    
    /**
     * Find In By Id List
     *
     * @param $ids
     *
     * @return mixed
     */
    public static function findInById($idList, $filter = null, $field = 'id')
    {
        $idList = empty($idList)? [null] : $idList;
        
        $filter ??= function ($id) {
            return (int) $id;
        };
        
        $query = self::query();
        $query->inWhere($field, array_map($filter, $idList));
        return $query->execute();
    }
    
    /**
     * @param null $parameters
     *
     * @return array|null
     */
    private static function _findInParameters($parameters = null)
    {
        // binding is allowed only in array
        if (!is_array($parameters)) {
            return $parameters;
        }

        // getting conditions from 0 or conditions parameter
        if (!empty($parameters['conditions'])) {
            $conditions = & $parameters['conditions'];
        } elseif (!empty($parameters[0])) {
            $conditions = & $parameters[0];
        } else {
            $conditions = '';
        }

        // finding largest already set placeholder to avoid conflicts
        if (preg_match('/.*\?(\d+)/', $conditions, $matches)) {
            $i = $matches[1] + 1;
        } else {
            $i = 0;
        }

        /*
         * check if exists bind and replace all arrays to ?0 ?1 etc
         */
        if (!empty($parameters['bind'])) {
            foreach ($parameters['bind'] as $key => $binded) {
                if (is_array($binded)) {
                    $placeholders = array();
                    $binds = array();
                    foreach ($binded as $bind) {
                        $placeholders[] = '?' . $i;
                        $parameters['bind'][$i] = $bind;
                        $i++;
                    }
                    unset($parameters['bind'][$key]);
                    $conditions = str_replace(':' . $key . ':', implode(', ', $placeholders), $conditions);
                }
            }
        }
        return $parameters;
    }
}
