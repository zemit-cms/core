<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Bootstrap;

use Zemit\Di\Injectable;

class Prepare extends Injectable
{
    public function __construct()
    {
        $this->initialize();
        $this->trustForwardedProto();
    }

    /**
     * Initialisation
     */
    public function initialize(): void
    {
    }

    /**
     * Trust forwarded protocol and force $_SERVER['https'] to 'on'
     * @todo move this to request?
     */
    public function trustForwardedProto(): void
    {
        if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '', 'https') !== false) {
            $_SERVER['HTTPS'] = 'on';
        }
    }

    /**
     * Prepare debugging
     * @todo review this
     */
    public function debug(?bool $debug = null): void
    {
        $debug ??= $this->config->get('app.debug') || $this->config->get('debug.enable');
        if ($debug) {
            // Enabling error reporting and display
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            // Disabling error reporting and display
            error_reporting(-1);
            ini_set('display_errors', 0);
        }
    }

    /**
     * Prepare some PHP config
     * @todo review this
     */
    public function php(array $config = []): void
    {
        date_default_timezone_set($config['timezone'] ?? 'America/Montreal');
        
        setlocale(LC_ALL, 'fr_CA.' . $config['encoding'], 'French_Canada.1252');
        mb_internal_encoding($config['encoding'] ?? 'UTF-8');
        mb_http_output($config['encoding'] ?? 'UTF-8');
        
        ini_set('memory_limit', $config['memoryLimit'] ?? '256M');
        ini_set('max_execution_time', $config['timeoutLimit'] ?? '60');
        set_time_limit($config['timeoutLimit'] ?? 60);
    }
}
