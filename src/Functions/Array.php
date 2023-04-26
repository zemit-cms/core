<?php

if (!function_exists('array_unset_recursive')) {
    
    function array_unset_recursive(array &$array, array $keyList, bool $strict = true): int
    {
        $removeCount = 0;
        foreach ($array as $key => $element) {
            if (in_array($key, $keyList, $strict)) {
                unset($array[$key]);
                $removeCount++;
            }
            elseif (is_array($element)) {
                array_unset_recursive($array[$key], $keyList, $strict);
            }
        }
        return $removeCount;
    }
}

if (!function_exists('array_search_key_recursive')) {
    
    function array_search_key_recursive(array &$array, array $keyList, bool $strict = true): int
    {
        foreach ($array as $key => $element) {
            if (in_array($key, $keyList, $strict)) {
                return true;
            }
            elseif (is_array($element)) {
                return array_search_key_recursive($array[$key], $keyList, $strict);
            }
        }
        return false;
    }
}

