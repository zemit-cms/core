<?php

namespace Zemit\Core\Bootstrap;

use Zemit\Core\Utils\Locale;
use Zemit\Core\Utils\Env;
use Phalcon\Config as PhalconConfig;
use PDO;

class Config extends PhalconConfig
{
    
    public function __construct($config = array())
    {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getEnv::get('APPLICATION_ENV') ? getEnv::get('APPLICATION_ENV') : 'development'));
        $corePackage = 'zemit-official/cms-core';
        $corePath = VENDOR_PATH . '/' . $corePackage . '/src/';
        
        parent::__construct(array(
            /**
             * Default namespace
             */
            'namespace' => 'Zemit',
            
            /**
             * Default general settings
             */
            'version' => Env::get('APP_VERSION', date('Ymd')), // allow to set and force a specific version
            'maintenance' => Env::get('APP_MAINTENANCE', false), // Set true to force the maintenance page
            'env' => Env::get('APP_ENV', APPLICATION_ENV), // Set the current environnement
            'cache' => Env::get('APP_CACHE', false), // Set true to activate the cache
            'minify' => Env::get('APP_MINIFY', false), // Set true to activate the cache
            'copyright' => Env::get('APP_COPYRIGHT', false), // Set true to activate the cache
            'debug' => Env::get('APP_DEBUG', false), // Set true to display php debug
            'profiler' => Env::get('APP_PROFILER', false), // Set true to return the profiler
            'logger' => Env::get('APP_LOGGER', false), // Set true to log database transactions
    
            /**
             * Default security settings
             */
            'security' => array( // phalcon security config
                'workfactor' => Env::get('SECURITY_WORKFACTOR', 12), // workfactor for the phalcon security service
                'salt' => Env::get('SECURITY_SALT', 'ZEMIT_CORE_DEFAULT_SALT') // salt for the phalcon security service
            ),
    
            /**
             * Default local settings
             */
            'locale' => array(
                'default' => 'en',
                'sessionKey' => 'zemit-locale',
                'mode' => Locale::MODE_SESSION_GEOIP,
                'list' => [
                    'en', 'en_US',
                    'fr', 'fr_FR',
                ]
            ),
    
            /**
             * Default translater settings
             */
            'translate' => [
                'locale' => 'en_US.utf8',
                'defaultDomain' => 'messages',
                'category' => LC_MESSAGES,
                'directory' => [
                    'messages' => $corePath . 'Lang'
                ],
            ],
    
            /**
             * Default modules
             */
            'modules' => array(
                'frontend' => [
                    'className' => 'Zemit\\Core\\Frontend\\Module',
                    'path' => $corePath . 'Frontend/Module.php'
                ],
                'backend' => [
                    'className' => 'Zemit\\Core\\Backend\\Module',
                    'path' => $corePath . 'Backend/Module.php'
                ],
                'api' => [
                    'className' => 'Zemit\\Core\\Api\\Module',
                    'path' => $corePath . 'Api/Module.php'
                ],
            ),
    
            /**
             * Default router settings
             */
            'router' => array(
                'defaults' => array(
                    'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
                    'module' => 'frontend',
                    'controller' => 'index',
                    'action' => 'index'
                ),
                'notFound' => array(
                    'controller' => 'errors',
                    'action' => 'notFound'
                )
            ),
    
            /**
             * Core specific settings
             */
            'core' => [
                'version' => '0.1.0',
                'package' => $corePackage,
                'modules' => [
                    'Api' => 'Zemit\\Core\\Api',
                    'Frontend' => 'Zemit\\Core\\Frontend',
                    'Backend' => 'Zemit\\Core\\Backend',
                ],
                'dir' => [
                    'base' => $corePath,
                    'locales' => $corePath . 'Lang',
                ],
            ],
    
            /**
             * Default module/plugin structure
             */
            'module' => [
                'dir' => [
                    // default
                    'modules' => 'modules/',
                    'controllers' => 'controllers/',
                    'tasks' => 'tasks/',
                    'models' => 'models/',
                    'views' => 'views/',
                    'helpers' => 'helpers/',
                    'bootstrap' => 'bootstrap/',
                    'locales' => 'locales/',
                    'config' => 'config/',
                    
                    // private
                    'migrations' => 'private/migrations/',
                    'cache' => 'private/cache/',
                    'logs' => 'private/logs/',
                    'backup' => 'private/backup/',
                    'files' => 'private/files/',
                    'trash' => 'private/trash/',
                    'sql' => 'private/sql/',
                ],
            ],
    
            /**
             * Application configuration
             */
            'app' => array(
                'baseUri' => '',
                'dir' => [
                    // default
                    'modules' => APPLICATION_PATH . '/modules/',
                    'config' => APPLICATION_PATH . '/config/',
                    'bootstrap' => APPLICATION_PATH . '/bootstrap/',
    
                    // private
                    'cache' => PRIVATE_PATH . '/cache/',
                    'logs' => PRIVATE_PATH . '/logs/',
                    'backups' => PRIVATE_PATH . '/backups/',
                    'files' => PRIVATE_PATH . '/files/',
                    'trash' => PRIVATE_PATH . '/trash/',
                    'sql' => PRIVATE_PATH . '/sql/',
                    'migrations' => APPLICATION_PATH . '/migrations/',
                    'vendor' => VENDOR_PATH,
    
                    // project
                    'base' => APPLICATION_PATH,
                    'project' => ROOT_PATH,
                ],
            ),
    
            /**
             * Database configuration
             */
            'database' => array(
                'adapter' => 'Mysql',
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => '',
                'charset' => 'utf8',
                'options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                )
            ),
    
            /**
             * Mailer configuration
             */
            'mail' => array(
                'driver' => 'sendmail',
                'sendmail' => '/usr/sbin/sendmail -bs',
                'from' => array(
                    'email' => 'no-reply@zemit.com',
                    'name' => 'Zemit'
                ),
                'bcc' => array(
                    'contat@zemit.com' => 'Zemit',
                ),
                'viewsDir' => APPLICATION_PATH . '/modules/frontend/views/',
            ),
            'client' => array(),
        ));
        if (!empty($config)) {
            $this->merge(new PhalconConfig($config));
        }
    }
    
    public function mergeEnvConfig($env = APPLICATION_ENV)
    {
        $configFile = $this->app->dir->config . 'env/config.' . $env . '.php';
        if (file_exists($configFile)) {
            $envConfig = require_once $configFile;
            if (!empty($envConfig)) {
                $this->merge(new PhalconConfig(is_callable($envConfig) ? $envConfig() : $envConfig));
            }
        }
        return $this;
    }
}

//if (php_sapi_name() === 'cli') {
//    $devtoolConfig = new Config();
//    return $devtoolConfig->mergeEnvConfig();
//}