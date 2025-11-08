<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Support\Helper\Arr;

/**
 * This class provides methods to parse an array into a flatten array with key path separated by a delimiter.
 */
class FlattenKeys
{
    public function __invoke(array $collection = [], string $delimiter = '.', bool $lowerKey = true): array
    {
        return self::process($collection, $delimiter, $lowerKey) ?? [];
    }
    
    /**
     * Here to parse the columns parameter into some kind of flatten array with
     * the key path separated by dot "my.path" and the value true, false or a callback function
     * including the ExposeBuilder object
     */
    public static function process(array $collection = [], string $delimiter = '.', bool $lowerKey = false, ?string $context = null): ?array
    {
        $ret = [];
        
        foreach ($collection as $key => $value) {
            // flip value to key
            if (is_int($key)) {
                if (is_string($value)) {
                    $key = $value;
                    $value = true;
                }
                else {
                    $key = null;
                }
            }
            
            // force lower case key
            if (is_string($key)) {
                $key = trim($lowerKey ? mb_strtolower($key) : $key);
            }
            
            // true for empty string
            if (is_string($value) && empty($value)) {
                $value = true;
            }
            
            // set the key
            $currentKey = (!empty($context) ? $context . (!empty($key) ? $delimiter : null) : null) . $key;
            if (is_callable($value)) {
                $value = $value();
            }
            
            if (is_array($value)) {
                $subRet = self::process($value, $delimiter, $lowerKey, $currentKey);
                if (is_array($subRet)) {
                    $ret = array_merge_recursive($ret, $subRet);
                }
                
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
