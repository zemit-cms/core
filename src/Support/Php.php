<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

class Php
{
    public static function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }
    
    /**
     * Trust forwarded protocol and force $_SERVER['https'] to 'on'
     */
    public static function trustForwardedProto(): void
    {
        if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '', 'https') !== false) {
            $_SERVER['HTTPS'] = 'on';
        }
    }

    /**
     * Set debugging values
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
     * Prepare some PHP config
     * @todo review to implement this properly
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
