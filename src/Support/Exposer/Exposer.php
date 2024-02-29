<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\Exposer;

use Zemit\Mvc\Model;

/**
 * Class Expose
 * @todo rewrite this code
 * @todo write unit test for this
 *
 * Example
 *
 * Simple
 * ```php
 * $this->expose() // expose everything except protected properties
 * $this->expose(null, true, true); // expose everything including protected properties
 * $this->expose(array('Source.id' => false)) // expose everything except 'id' and protected properties
 * $this->expose(array('Source' => array('id', 'title')) // expose only 'id' and 'title'
 * $this->expose(array('Source' => true, false) // expose everything from Source except protected properties
 * $this->expose(array('Source.Sources' => true, false) // expose everything from Source->Sources except protected properties
 * $this->expose(array('Source.Sources' => array('id'), false) // expose only the 'id' field of the sub array "Sources"
 * $this->expose(array('Source.Sources' => array(true, 'id' => false), false) // expose everything from the sub array "Sources" except the 'id' field
 * $this->expose(array('Source' => array(false, 'Sources' => array(true, 'id' => false))) // expose everything from the sub array "Sources" except the 'id' field
 * ```
 * Complexe
 *
 *
 * @package Zemit\Mvc\Model\Expose
 */
class Exposer
{
    public static function createBuilder(mixed $object, ?array $columns = null, ?bool $expose = null, ?bool $protected = null): Builder
    {
        $expose ??= true;
        $protected ??= false;
        
        $builder = new Builder();
        $builder->setColumns(self::parseColumnsRecursive($columns));
        $builder->setExpose($expose);
        $builder->setProtected($protected);
        $builder->setValue($object);
        return $builder;
    }
    
    private static function getValue(string $string, mixed $value): string
    {
        // @todo maybe we should remove the sprintf manipulation
        return mb_vsprintf($string, [$value]);
    }
    
    private static function checkExpose(Builder $builder): void
    {
        $columns = $builder->getColumns();
        $fullKey = $builder->getFullKey();
        $value = $builder->getValue();
        
        // Check if the key itself exists at first
        if (isset($columns[$fullKey])) {
            $column = $columns[$fullKey];
            
            // If boolean, set expose to the boolean value
            if (is_bool($column)) {
                $builder->setExpose($column);
            }
            
            // If callable, set the expose to true, and run the method and passes the builder as parameter
            elseif (is_callable($column)) {
                $builder->setExpose(true);
                $callbackReturn = $column($builder);
                
                // If builder is returned, no nothing
                if ($callbackReturn instanceof BuilderInterface) {
                    $builder = $callbackReturn;
                }
                
                // If string is returned, set expose to true and parse with mb_sprintfn or mb_sprintf
                elseif (is_string($callbackReturn)) {
                    $builder->setExpose(true);
                    $builder->setValue(self::getValue($callbackReturn, $value));
                }
                
                // If bool is returned, set expose to boolean value
                elseif (is_bool($callbackReturn)) {
                    $builder->setExpose($callbackReturn);
                }
                
                // If array is returned, parse the columns from the current context key and merge it with the builder
                elseif (is_iterable($callbackReturn)) {
                    $columns = self::parseColumnsRecursive($callbackReturn, $builder->getFullKey());
                    
                    // If not set, set expose to false by default
                    if (!isset($columns[$builder->getFullKey()])) {
                        $columns[$builder->getFullKey()] = false;
                    }
                    
                    //@TODO handle with array_merge_recursive and handle array inside the columns parameters ^^
                    $builder->setColumns(array_merge($builder->getColumns() ?? [], $columns));
                }
            }
            
            // If is string, set expose to true and parse with mb_sprintfn or mb_sprintf
            elseif (is_string($column)) {
                $builder->setExpose(true);
                $builder->setValue(self::getValue($column, $value));
            }
        }
        
        // Otherwise, check if a parent key exists
        else {
            $parentKey = $fullKey;
            $parentIndex = strrpos($parentKey, '.');
            do {
                $parentKey = $parentIndex ? substr($parentKey, 0, $parentIndex) : '';
                if (isset($columns[$parentKey])) {
                    $column = $columns[$parentKey];
                    if (is_bool($column)) {
                        $builder->setExpose($column);
                    }
                    elseif (is_callable($column)) {
                        $builder->setExpose(true);
                        $callbackReturn = $column($builder);
                        if ($callbackReturn instanceof BuilderInterface) {
                            $builder = $callbackReturn;
                        }
                        elseif (is_string($callbackReturn)) {
                            $builder->setExpose(true);
                            $builder->setValue(self::getValue($callbackReturn, $value));
                        }
                        elseif (is_bool($callbackReturn)) {
                            $builder->setExpose($callbackReturn);
                        }
                        elseif (is_iterable($callbackReturn)) {
                            // Since it is a parent, we're not supposed to re-re-merge the existing columns
                        }
                    }
                    elseif (is_string($column)) {
                        $builder->setExpose(false);
                        $builder->setValue(self::getValue($column, $value));
                    }
                    break;
                    // break at the first parent found
                }
            }
            while ($parentIndex = strrpos($parentKey, '.'));
        }
        
        if (isset($fullKey) && !empty($columns)) {
            // Try to find a subentity, or field that has the true value
            $value = $builder->getValue();
            if (is_iterable($value) || is_callable($value)) {
                foreach ($columns as $columnKey => $columnValue) {
                    if ($columnValue === true && str_starts_with($columnKey, $fullKey)) {
                        // expose the current instance (which is the parent of the sub column)
                        $builder->setExpose(true);
                    }
                }
            }
        }
        
        // check for protected setting
        $key = $builder->getKey();
        if (!$builder->getProtected() && is_string($key) && str_starts_with($key, '_')) {
            $builder->setExpose(false);
        }
    }
    
    /**
     * @return array|false|Model
     */
    public static function expose(Builder $builder)
    {
        $columns = $builder->getColumns();
        $value = $builder->getValue();
        
        if (is_iterable($value)) {
            $toParse = is_object($value) && method_exists($value, 'toArray')
                ? $value->toArray()
                : (array)$value;
            
            // si accused column demandé et que l'expose est à false
            if (is_null($columns) && !$builder->getExpose()) {
                return [];
            }
            
            // Prépare l'array de retour des fields de l'instance
            $ret = [];
            $currentContextKey = $builder->getContextKey();
            $builder->setContextKey($builder->getFullKey());
            foreach ($toParse as $fieldKey => $fieldValue) {
                $builder->setParent($value);
                $builder->setKey($fieldKey);
                $builder->setValue($fieldValue);
                self::checkExpose($builder);
                if ($builder->getExpose()) {
                    $ret [$fieldKey] = self::expose($builder);
                }
            }
            $builder->setContextKey($currentContextKey);
        }
        else {
            $ret = $builder->getExpose() ? $value : null;
        }
        
        return $ret;
    }
    
    /**
     * Here to parse the columns parameter into some kind of flatten array with
     * the key path separated by dot "my.path" and the value true, false or a callback function
     * including the ExposeBuilder object
     *
     * @param iterable|null $columns
     * @param string|null $context
     *
     * @return array|null
     */
    public static function parseColumnsRecursive(?iterable $columns = null, ?string $context = null): ?array
    {
        if (!isset($columns)) {
            return null;
        }
        $ret = [];
        foreach ($columns as $key => $value) {
            if (is_bool($key)) {
                $value = $key;
                $key = null;
            }
            
            if (is_int($key)) {
                if (is_string($value)) {
                    $key = $value;
                    $value = true;
                }
                else {
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
            if (is_callable($value)) {
                $ret[$currentKey] = $value;
            }
            else if (is_iterable($value)) {
                $subRet = self::parseColumnsRecursive($value, $currentKey);
                $ret = array_merge_recursive($ret, $subRet ?? []);
                if (!isset($ret[$currentKey])) {
                    $ret[$currentKey] = false;
                }
            }
            else {
                $ret[$currentKey] = $value;
            }
        }
        
        return $ret;
    }
}
