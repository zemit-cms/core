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

use Phalcon\Debug;
use Phalcon\Config;
use Zemit\Di\Injectable;
use Zemit\Events\EventsAwareTrait;

/**
 * Class Prepare
 * Prepare raw php stuff early in the bootstrap
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Bootstrap
 */
class Prepare extends Injectable
{
    use EventsAwareTrait;
    
    private static bool $initialized = false;
    
    /**
     * Prepare raw php stuff
     * - Initialize
     * - Random fixes
     * - Define constants
     * - Force debug
     * - Force PHP settings
     */
    public function __construct()
    {
        $this->initialize();
        $this->forwarded();
        $this->define();
//        $this->debug();
//        $this->php();
        self::$initialized = true;
    }
    
    /**
     * Initialisation
     */
    public function initialize()
    {
    }
    
    /**
     * Fix for forwarded https
     */
    protected function forwarded()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $_SERVER['HTTPS'] = 'on';
        }
    }
    
    /**
     * Prepare application environment variables
     * - APPLICATION_ENV
     * - APP_ENV
     * - ENV
     */
    protected function define()
    {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
        defined('APP_ENV') || define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : APPLICATION_ENV));
        defined('ENV') || define('ENV', (getenv('ENV') ? getenv('ENV') : APPLICATION_ENV));
    }
    
    /**
     * Prepare debugging
     * - Prepare error reporting and display errors natively with PHP
     * - Listen with phalcon debugger
     */
    public function debug(Config $config = null)
    {
        $config ??= $this->config;
        
        if ($config->app->debug || $config->debug->enable) {
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
     * - Should be initialized only once
     *
     * @param Config|null $config
     * @param false $force
     */
    public function php(Config $config = null, $force = false) : void
    {
        if (!$force && self::$initialized) {
            return;
        }
    
        $appConfig = $config->app ?? $this->config->app;

        if ($appConfig) {
            setlocale(LC_ALL, 'fr_CA.' . $appConfig->encoding, 'French_Canada.1252');
            date_default_timezone_set($appConfig->timezone ?? 'America/Montreal');
            mb_internal_encoding($appConfig->encoding ?? 'UTF-8');
            mb_http_output($appConfig->encoding ?? 'UTF-8');
            ini_set('memory_limit', $appConfig->memoryLimit ?? '256M');
            ini_set('post_max_size', $appConfig->postLimit ?? '20M');
            ini_set('upload_max_filesize', $appConfig->postLimit ?? '20M');
            ini_set('max_execution_time', $appConfig->timeoutLimit ?? '60');
            ini_set('html_errors', $appConfig->htmlErrors ?? 0);
            set_time_limit($appConfig->timeoutLimit ?? '60');
        }
    }
}
