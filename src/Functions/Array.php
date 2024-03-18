<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

if (!function_exists('array_unset_recursive')) {
    
    function array_unset_recursive(array &$array, array $keyList, bool $strict = true): int
    {
        $removeCount = 0;
        foreach ($array as $key => $element) {
            if (in_array($key, $keyList, $strict)) {
                unset($array[$key]);
                $removeCount++;
            } elseif (is_array($element)) {
                $removeCount += array_unset_recursive($array[$key], $keyList, $strict);
            }
        }
        return $removeCount;
    }
}
