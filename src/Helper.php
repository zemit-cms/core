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

class Helper {
    
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    public static function dd() {
        call_user_func_array('dd', func_get_args());
    }
    
    /**
     * Dump the passed variables without end the script.
     *
     * @param  mixed
     * @return void
     */
    public static function dump() {
        call_user_func_array('dump', func_get_args());
    }
    
    /**
     * Call a function
     * - Uncamelize the method name
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws \Exception Throw exception if function name can't be found
     */
    public function __call($name, $arguments) {
        return self::__callStatic($name, $arguments);
    }
    
    /**
     * Call a function
     * - Uncamelize the method name
     *
     * @param $name
     * @param $arguments
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
        die(1);
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
        array_map(function ($x) {
            $string = (new Dump([], true))->variable($x);
            echo (PHP_SAPI == 'cli' ? strip_tags($string) . PHP_EOL : $string);
        }, func_get_args());
    }
}