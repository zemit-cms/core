<?php

use Phalcon\Debug\Dump;

if (!function_exists('vdd')) {
    /**
     * Dump the passed variables and end the script.
     */
    function vdd(...$params): void
    {
        var_dump(...$params);
        exit_500();
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     */
    function dd(...$params): void
    {
        dump(...$params);
        exit_500();
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

if (!function_exists('exit_500')) {
    /**
     * Exit and set header
     */
    function exit_500(): void
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            header('500 Internal Server Error');
        }
        exit(1);
    }
}
