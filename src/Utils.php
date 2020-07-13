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
 * @package Zemit
 */
class Utils
{
    /**
     * @param $class
     *
     * @return bool|string
     */
    public static function getNamespace(object $class) : string
    {
        return substr(get_class($class), 0, strrpos(get_class($class), "\\"));
    }
    
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    public static function dd()
    {
        call_user_func_array('dd', func_get_args());
    }
    
    /**
     * Dump the passed variables without end the script.
     *
     * @param  mixed
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
        } else {
            throw new \Exception("Function {$functionName} does not exists.");
        }
    }
}
if (!function_exists('dd')) {
    
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
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
     * @param  mixed
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
