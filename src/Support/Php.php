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

/**
 * Class Php
 *
 * Provides utility methods for working with PHP settings and environment.
 */
class Php
{
    /**
     * Check if the script is running in a command-line interface (CLI) environment.
     *
     * @return bool Returns true if the script is running in a CLI environment, false otherwise.
     */
    public static function isCli(string $sapi = PHP_SAPI): bool
    {
        return in_array($sapi, ['cli', 'phpdbg'], true);
    }
    
    /**
     * Trust the forwarded protocol from the reverse proxy server.
     * If trusted and HTTP_X_FORWARDED_PROTO is https force $_SERVER['https'] to 'on'
     *
     * @return void
     */
    public static function trustForwardedProto(): void
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if (str_starts_with($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https')) {
                $_SERVER['HTTPS'] = 'on';
            }
        }
    }
    
    /**
     * Enable or disable debug mode
     *
     * @param bool|null $debug Set to true to enable debug mode, false to disable it. If null, debug mode remains unchanged.
     *
     * @return void
     */
    public static function debug(?bool $debug = null): void
    {
        if ($debug) {
            // Enabling error reporting and display
            error_reporting(E_ALL);
            ini_set('display_startup_errors', '1');
            ini_set('display_errors', '1');
        } else {
            // Disabling error reporting and display
            error_reporting(-1);
            ini_set('display_startup_errors', '0');
            ini_set('display_errors', '0');
        }
    }
    
    /**
     * Set the configuration options for the application.
     *
     * @param array $config The configuration options for the application.
     * @return void
     */
    public static function set(array $config = []): void
    {
        $config['timezone'] ??= 'America/Montreal';
        $config['encoding'] ??= 'UTF-8';
        $config['locale'] ??= 'en_CA';
        $config['memoryLimit'] ??= '256M';
        $config['timeoutLimit'] ??= '60';
        
        date_default_timezone_set($config['timezone']);
        setlocale(LC_ALL, $config['locale'] . '.' . $config['encoding']);
        mb_internal_encoding($config['encoding']);
        mb_http_output($config['encoding']);
        
        ini_set('memory_limit', $config['memoryLimit']);
        ini_set('max_execution_time', (string)$config['timeoutLimit']);
        set_time_limit((int)$config['timeoutLimit']);
    }
}
