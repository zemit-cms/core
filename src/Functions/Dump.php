<?php

use Phalcon\Debug\Dump;

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
