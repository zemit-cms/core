<?php

namespace Zemit\Core\Mvc\Model;

trait FindIn {
    
    public static function findIn(array $keys) {
        $keys = $keys ? $keys : array(null);
        
        $intFilter = function($id) {
            return (int) $id;
        };
        $query = self::query();
        foreach ($keys as $key => $ids) {
            $query->inWhere($key, array_map($intFilter, $ids));
        }
        
        return $query->execute();
    }
    
    public static function findInById($ids) {
        $ids = $ids ? $ids : array(null);
        $intFilter = function($ids) {
            return (int) $ids;
        };
        $query = self::query();
        $query->inWhere('id', array_map($intFilter, $ids));
        return $query->execute();
    }

    private static function _findInParameters($parameters = null) {
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
