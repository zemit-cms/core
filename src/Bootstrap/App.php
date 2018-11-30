<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Debug;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class App {
    
    public $debug;
    
    /**
     * App constructor.
     */
    public function __construct() {
        $this->_forwardedHttps();
        $this->_defineApp();
        $this->_debugApp();
        $this->_formatApp();
        $this->_phpIni();
    }
    
    protected function _forwardedHttps() {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $_SERVER['HTTPS'] = 'on';
        }
    }
    
    /**
     * Configure la constate APPLICATION_ENV et prépare
     * le rapport d'erreur avant même d'avoir chargé la config
     */
    protected function _defineApp() {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
        defined('ENV') || define('ENV', (getenv('ENV') ? getenv('ENV') : APPLICATION_ENV));
    }
    
    protected function _debugApp() {
        // Enable error reporting and display
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // Prepare the phalcon debug listener
//        $this->debug = new Debug();
//        $this->debug->listen();
    }
    
    protected function _formatApp() {
        /**
         * Prepare some default timezone / encoding / locale / output
         * - Montréal
         * - UTF-8
         * - FR-CA
         */
        date_default_timezone_set('America/Montreal');
        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');
//        setlocale(LC_ALL, 'fr_CA.UTF-8', 'French_Canada.1252');
    }
    
    protected function _phpIni() {
        ini_set('memory_limit', '256M');
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '20M');
        ini_set('max_execution_time', '60');
        set_time_limit(60);
    }
}