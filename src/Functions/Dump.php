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

use Phalcon\Support\Debug\Dump;

if (!function_exists('dump')) {
    /**
     * Dump the passed variables and end the script.
     * @param mixed ...$params The variables to be dumped.
     * @return void
     */
    function dump(...$params): void
    {
        if (in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
            echo json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            echo PHP_EOL;
        } else {
            $dump = (new Dump([], true));
            foreach ($params as $param) {
                echo $dump->variable($param);
            }
        }
    }
}

if (!function_exists('exit_500')) {
    /**
     * Terminate execution with a 500 Internal Server Error response code.
     *
     * This function sets the response headers to indicate a 500 Internal Server Error
     * and terminates the execution of the script. It should be used when an unrecoverable
     * error occurs and the server cannot fulfill the request.
     *
     * @return void
     */
    function exit_500(): void
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            http_response_code(500);
        }
        exit(1);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump variables and terminate execution with an error 500.
     * @param mixed ...$params The variables to be dumped.
     * @return void
     */
    function dd(...$params): void
    {
        dump(...$params);
        exit_500();
    }
}

if (!function_exists('vdd')) {
    /**
     * Prints the values of the given parameters using var_dump and
     * then exits the program with a HTTP response status code of 500.
     *
     * @param mixed ...$params The parameters to be dumped.
     * @return void
     */
    function vdd(...$params): void
    {
        /**
         * @psalm-suppress ForbiddenCode
         */
        var_dump(...$params);
        exit_500();
    }
}
