<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

class Utils
{
    /**
     * Remove time and memory limits
     */
    public static function setUnlimitedRuntime(): void
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', 0);
        set_time_limit(0);
    }
    
    /**
     * Get the Namespace from a class object
     */
    public static function getNamespace(object $class): string
    {
        return (new \ReflectionClass($class))->getNamespaceName();
    }
    
    /**
     * Get the Namespace from a class object
     */
    public static function getShortName(object $class): string
    {
        return (new \ReflectionClass($class))->getShortName();
    }
    
    /**
     * Get the Namespace from a class object
     */
    public static function getName(object $class): string
    {
        return (new \ReflectionClass($class))->getName();
    }
    
    /**
     * Get the directory from a class object
     */
    public static function getDirname(object $class): string
    {
        return dirname((new \ReflectionClass($class))->getFileName());
    }
    
    /**
     * Return an array of the current memory usage in MB
     *
     * @return array{
     *      memory: string,
     *      memoryPeak: string,
     *      realMemory: string,
     *      realMemoryPeak: string,
     *  }
     */
    public static function getMemoryUsage(float $divider = 1048576.2, string $suffix = ' MB'): array
    {
        return [
            'memory' => number_format((float)memory_get_usage() / $divider, 2) . $suffix,
            'memoryPeak' => number_format((float)memory_get_peak_usage() / $divider, 2) . $suffix,
            'realMemory' => number_format((float)memory_get_usage(true) / $divider, 2) . $suffix,
            'realMemoryPeak' => number_format((float)memory_get_peak_usage(true) / $divider, 2) . $suffix,
        ];
    }
}
