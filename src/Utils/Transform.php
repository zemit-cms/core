<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Utils;

/**
 * Class Slug
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Utils
 */
class Transform
{
    /**
     * Here to parse the columns parameter into some kind of flatten array with
     * the key path separated by dot "my.path" and the value true, false or a callback function
     * including the ExposeBuilder object
     *
     * @param mixed $array
     * @param string|null $context
     * @param string|null $delimiter
     *
     * @return array|null
     */
    final public static function flattenKeys($array = null, ?string $delimiter = '.', ?bool $lowerKey = true, ?string $context = null) : ?array
    {
        // nothing passed
        if (!isset($array)) {
            return null;
        }
        
        $ret = [];
        
        if (!is_array($array) || !is_object($array)) {
            $array = [$array];
        }
        
        foreach ($array as $key => $value) {
            
            // handle our special attribute
            if (is_bool($key)) {
                $value = $key;
                $key = null;
            }
            
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
            
            //
            if (is_string($value) && empty($value)) {
                $value = true;
            }
            
            // set the key
            $currentKey = (!empty($context) ? $context . (!empty($key) ? $delimiter : null) : null) . $key;
            
            if (is_array($value) || is_object($value)) {
                $subRet = self::flattenKeys(is_callable($value)? $value() : $value, $delimiter, $lowerKey, $currentKey);
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
