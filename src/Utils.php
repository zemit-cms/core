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
use Phalcon\Text;

/**
 * Class Utils
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit
 */
class Utils
{
    /**
     * Remove time and memory limits
     * @return void
     */
    public static function setUnlimitedRuntime() {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', 0);
        set_time_limit(0);
    }
    
    /**
     * Set max upload file size and post size
     * @param string $size
     * @return void
     */
    public static function setMaxUploadFileSize(string $size = '2M') {
        ini_set('upload_max_filesize', $size);
        ini_set('post_max_size', $size);
    }
    
    /**
     * @param $class
     *
     * @return bool|string
     */
    public static function getNamespace(object $class): string
    {
        return substr(get_class($class), 0, strrpos(get_class($class), "\\"));
    }
    
    /**
     * @param object|string $class
     * @return string
     */
    public static function getDirname($class): string
    {
        return dirname((new \ReflectionClass($class))->getFileName());
    }
    
    /**
     * Return a human readable memory usage array (in MB)
     * @return string[]
     */
    public static function getMemoryUsage(): array
    {
        $toMb = 1048576.2;
        return [
            'memory' => (memory_get_usage() / $toMb) . ' MB',
            'memoryPeak' => (memory_get_peak_usage() / $toMb) . ' MB',
            'realMemory' => (memory_get_usage(true) / $toMb) . ' MB',
            'realMemoryPeak' => (memory_get_peak_usage(true) / $toMb) . ' MB',
        ];
    }
    
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed
     * @return void
     */
    public static function dd()
    {
        call_user_func_array('dd', func_get_args());
    }
    
    /**
     * Dump the passed variables without end the script.
     *
     * @param mixed
     * @return void
     */
    public static function dump()
    {
        call_user_func_array('dump', func_get_args());
    }
    
    /**
     * Call a function
     * - Uncamelize the method name
     *
     * @param $name string
     * @param $arguments array
     *
     * @return mixed
     * @throws \Exception Throw exception if function name can't be found
     */
    public function __call(string $name, array $arguments)
    {
        return self::__callStatic($name, $arguments);
    }
    
    /**
     * Call a function
     * - Uncamelize the method name
     *
     * @param $name string
     * @param $arguments array
     *
     * @return mixed
     * @throws \Exception Throw exception if function name can't be found
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $functionName = Text::uncamelize($name);
        if (function_exists($functionName)) {
            return call_user_func_array($functionName, func_get_args());
        }
        else {
            throw new \Exception("Function {$functionName} does not exists.");
        }
    }
}

if (!function_exists('dd')) {
    
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed
     * @return void
     */
    function dd()
    {
        call_user_func_array('dump', func_get_args());
        exit(1);
    }
}

if (!function_exists('dump')) {
    /**
     * Dump the passed variables without end the script.
     *
     * @param mixed
     * @return void
     */
    function dump()
    {
        array_map(
            function ($variable) {
                $dump = new Dump([], true);
                $ret = $dump->variable($variable);
                if (PHP_SAPI === 'cli') {
                    $ret = strip_tags($ret) . PHP_EOL;
                }
                echo $ret;
            },
            func_get_args()
        );
    }
}
