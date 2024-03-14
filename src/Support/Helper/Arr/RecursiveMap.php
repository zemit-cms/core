<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\Helper\Arr;

/**
 * Class RecursiveMap
 *
 * This class provides a way to recursively process the elements of an array using a callback function.
 */
class RecursiveMap
{
    public function __invoke(array $collection = [], callable $callback = null): array
    {
        return self::process($collection, $callback);
    }
    
    /**
     * Applies a callback function to each element of the given array recursively and returns a new array.
     *
     * @param array $collection The array to be processed.
     * 
     * @param ?callable $callback The callback function to be applied to each array element.
     *                           The callback function should accept one argument, which is the current array element,
     *                           and can return a modified value for that element.
     *
     * @return array The processed array with the callback function applied to each element.
     */
    public static function process(array $collection = [], callable $callback = null): array
    {
        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };
        
        return array_map($func, $collection);
    }
}
