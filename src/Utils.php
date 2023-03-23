<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Phalcon\Debug\Dump;

/**
 * Class Utils
 */
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
     * Set max upload file size and post size
     * @link https://www.php.net/manual/en/ini.list.php
     * @link https://www.php.net/manual/en/configuration.changes.modes.php
     * @deprecated This setting must be changed at the system level
     * @throws \Exception
     */
    public static function setMaxUploadFileSize(string $size = '2M'): void
    {
        throw new \Exception('This setting must be changed at the system level.');
    }
    
    /**
     * Get the Namespace from a class object
     */
    public static function getNamespace(object $class): string
    {
        return (new \ReflectionClass($class))->getNamespaceName();
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
     */
    public static function getMemoryUsage(): array
    {
        $toMB = 1048576.2;
        return [
            'memory' => (memory_get_usage() / $toMB) . ' MB',
            'memoryPeak' => (memory_get_peak_usage() / $toMB) . ' MB',
            'realMemory' => (memory_get_usage(true) / $toMB) . ' MB',
            'realMemoryPeak' => (memory_get_peak_usage(true) / $toMB) . ' MB',
        ];
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     */
    function dd(...$params): void
    {
        dump(...$params);
        exit(1);
    }
}

if (!function_exists('dump')) {
    /**
     * Dump the passed variables without ending the script.
     */
    function dump(...$params): void
    {
        foreach ($params as $param) {
            $ret = (new Dump([], true))->variable($param);
            if (PHP_SAPI === 'cli') {
                $ret = strip_tags($ret) . PHP_EOL;
            }
            echo $ret;
        }
    }
}
