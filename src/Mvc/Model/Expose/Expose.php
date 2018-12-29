<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Expose;

use Zemit\Utils\Multibyte;
use Phalcon\Text;

/**
 * Class Expose
 *
 * Example
 *
 * Simple
 * $this->expose() // expose everything except protected properties
 * $this->expose(null, true, true); // expose everything including protected properties
 * $this->expose(array('Source.id' => false)) // expose everything except 'id' and protected properties
 * $this->expose(array('Source' => array('id', 'title')) // expose only 'id' and 'title'
 * $this->expose(array('Source' => true, false) // expose everything from Source except protected properties
 * $this->expose(array('Source.Sources' => true, false) // expose everything from Source->Sources except protected properties
 * $this->expose(array('Source.Sources' => array('id'), false) // expose only the 'id' field of the sub array "Sources"
 * $this->expose(array('Source.Sources' => array(true, 'id' => false), false) // expose everything from the sub array "Sources" except the 'id' field
 * $this->expose(array('Source' => array(false, 'Sources' => array(true, 'id' => false))) // expose everything from the sub array "Sources" except the 'id' field
 *
 * Complexe
 *
 *
 * @package Zemit\Mvc\Model\Expose
 */
trait Expose {
    
    public function expose($columns = null, $expose = true, $protected = false) {
        $builder = new Builder();
        $builder->setColumns(self::_parseColumnsRecursive($columns));
        $builder->setExpose($expose);
        $builder->setProtected($protected);
        $builder->setParent($this);
        $builder->setValue($this);
        $builder->setKey(trim(mb_strtolower(Text::camelize($this->getSource()))));
        return self::_expose($builder);
    }
    
    private static function _getValue($string, $value) {
        $ret = null;
        if (is_array($value) || is_object($value)) {
            $ret = Multibyte::sprintfn($string, $value);
        } else {
            $ret = Multibyte::mb_sprintf($string, $value);
        }
        return $ret;
    }
    
    private static function _checkExpose(Builder $builder) {
        $ret = null;
        $columns = $builder->getColumns();
        $fullKey = $builder->getFullKey();
        $value = $builder->getValue();
        
        // Check if the key itself exists at first
        if (isset($columns[$fullKey])) {
            $column = $columns[$fullKey];
            
            // If boolean, set expose to the bolean value
            if (is_bool($column)) {
                $builder->setExpose($column);
            }
            
            // If callable, set the expose to true, and run the method and passes the builder as parameter
            else if (is_callable($column)) {
                
                $builder->setExpose(true);
                $callbackReturn = $column($builder);
                
                // If builder is returned, no nothing
                if ($callbackReturn instanceof BuilderInterface) {
                    $builder = $callbackReturn;
                }
                
                // If string is returned, set expose to true and parse with mb_sprintfn or mb_sprintf
                else if (is_string($callbackReturn)) {
                    $builder->setExpose(true);
                    $builder->setValue(self::_getValue($callbackReturn, $value));
                }
                
                // If bool is returned, set expose to boolean value
                else if (is_bool($callbackReturn)) {
                    $builder->setExpose($callbackReturn);
                }
                
                // If array is returned, parse the columns from the current context key and merge it with the builder
                else if (is_array($callbackReturn)) {
                    $columns = self::_parseColumnsRecursive($callbackReturn, $builder->getFullKey());
                    
                    // If not set, set expose to false by default
                    if (!isset($columns[$builder->getFullKey()])) {
                        $columns[$builder->getFullKey()] = false;
                    }
                    
                    //@TODO handle with array_merge_recursive and handle array inside the columns parameters ^^
                    $builder->setColumns(array_merge($builder->getColumns(), $columns));
                }
            }
            
            // If string, set expose to true and parse with mb_sprintfn or mb_sprintf
            else if (is_string($column)) {
                $builder->setExpose(true);
                $builder->setValue(self::_getValue($column, $value));
            }
        }
        
        // Otherwise, check if a parent key exists
        else {
            $parentKey = $fullKey;
            
            while ($parentIndex = strrpos($parentKey, '.')) {
                $parentKey = substr($parentKey, 0, $parentIndex);
                
                if (isset($columns[$parentKey])) {
                    $column = $columns[$parentKey];
                    
                    if (is_bool($column)) {
                        $builder->setExpose($column);
                    }
                    else if (is_callable($column)) {
                        $builder->setExpose(true);
                        $callbackReturn = $column($builder);
                        if ($callbackReturn instanceof BuilderInterface) {
                            $builder = $callbackReturn;
                        } else if (is_string($callbackReturn)) {
                            $builder->setExpose(true);
                            $builder->setValue(self::_getValue($callbackReturn, $value));
                        } else if (is_bool($callbackReturn)) {
                            $builder->setExpose($callbackReturn);
                        }
                        else if (is_array($callbackReturn)) {
                            // Since its a parent, we're not supposed to re-re-merge the existings columns
                        }
                    }
                    else if (is_string($column)) {
                        $builder->setExpose(false);
                        $builder->setValue(self::_getValue($column, $value));
                    }
                    break; // break at the first parent found
                }
            }
        }
    
        // Try to find a subentity, or field that has the true value
        $value = $builder->getValue();
        if ((is_array($value) || is_object($value) || is_callable($value))) {
            $subColumns = is_null($columns) ? $columns : array_filter($columns, function($columnValue, $columnKey) use ($builder) {
                $ret = strpos($columnKey, $builder->getFullKey()) === 0;
                if ($ret && $columnValue === true) {
                    // expose the current instance (which is the parent of the subcolumn)
                    $builder->setExpose(true);
                }
                return $ret;
            }, ARRAY_FILTER_USE_BOTH);
        }
    
        // check for protected setting
        $key = $builder->getKey();
        if (!$builder->getProtected() && is_string($key) && strpos($key, '_') === 0) {
            $builder->setExpose(false);
        }
        
        return $builder;
    }
    
    private static function _expose(Builder $builder) {
        $builder = clone $builder;
        $columns = $builder->getColumns();
        $value = $builder->getValue();
        
        if (is_array($value) || is_object($value)) {
            
            // si aucune column demandé et que l'expose est à false
            if (is_null($columns) && !$builder->getExpose()) {
                return array();
            }
            
            // Prépare l'array de retour des fields de l'instance
            $ret = array();
            $builder->setContextKey($builder->getFullKey());
            foreach ($value as $fieldKey => $fieldValue) {
                $builder->setParent($value);
                $builder->setKey($fieldKey);
                $builder->setValue($fieldValue);
                self::_checkExpose($builder);
                if ($builder->getExpose()) {
                    $ret [$fieldKey]= self::_expose($builder);
                }
            }
        }
        else {
            $ret = $builder->getExpose()? $value : false;
        }
        return $ret;
    }

    /**
     * Here to parse the columns parameter into some kind of flattern array with
     * the key path saperated by dot "my.path" and the value true, false or a callback function
     * including the ExposeBuilder object
     *
     * @param Array $columns
     * @param String $context
     * @return Array
     */
    private static function _parseColumnsRecursive($columns = null, $context = null) {
        if (!isset($columns)) {
            return null;
        }
        $ret = [];
        if (!is_array($columns) || is_object($columns)) {
            $columns = array($columns);
        }
        foreach ($columns as $key => $value) {
            
            if (is_bool($key)) {
                $value = $key;
                $key = null;
            }
            
            if (is_int($key)) {
                if (is_string($value)) {
                    $key = $value;
                    $value = true;
                } else {
                    $key = null;
                }
            }
            
            if (is_string($key)) {
                $key = trim(mb_strtolower($key));
            }
            
            if (is_string($value) && empty($value)) {
                $value = true;
            }
            $currentKey = (!empty($context) ? $context . (!empty($key) ? '.' : null) : null) . $key;
            
            if (is_array($value) || is_object($value)) {
                if (is_callable($value)) {
                    $ret[$currentKey] = $value;
                } else {
                    
                    $subRet = self::_parseColumnsRecursive($value, $currentKey);
                    $ret = array_merge_recursive($ret, $subRet);
        
                    if (!isset($ret[$currentKey])) {
                        $ret[$currentKey] = false;
                    }
                }
            } else {
                $ret[$currentKey] = $value;
            }
        }
        return $ret;
    }

}
