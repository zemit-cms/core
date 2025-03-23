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
 * This class provides functionality to recursively replace specific patterns in strings
 * within a nested array structure using a key/value map of replacements.
 */
class RecursiveStrReplace
{
    public function __invoke(array $collection, array $replaces): array
    {
        return self::process($collection, $replaces) ?? [];
    }
    
    /**
     * Processes the given collection recursively, replacing specific key patterns in strings
     * with their corresponding values from the replaces array.
     *
     * @param array $collection The input array to be processed. It can contain nested arrays and/or strings.
     * @param array $replaces An associative array where keys are the patterns to be replaced, and values are the replacement strings.
     * @return array|null Returns the processed array with replaced values, or null if processing fails.
     */
    public static function process(array $collection, array $replaces): ?array
    {
        return array_map(function ($value) use ($replaces) {
            if (is_array($value)) {
                return self::process($value, $replaces);
            }
            if (is_string($value)) {
                return str_replace(array_keys($replaces), array_values($replaces), $value);
            }
            return $value;
        }, $collection);
    }
}
