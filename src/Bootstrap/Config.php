<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Config as PhalconConfig;
use PDO;

class Config extends PhalconConfig
{
    
    public function __construct($config = array())
    {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
        $appPath = realpath('../app');
        $appPath = empty($appPath) ? realpath(__DIR__ . '/../') . '/' : $appPath . '/';
        parent::__construct(array(
            'version' => date('YmdH'),
            'maintenance' => false,
            'env' => APPLICATION_ENV,
            'cache' => false,
            'debug' => false,
            'profiler' => false,
            'logger' => false,
            'https' => false,
            'theme' => 'default',
            'security' => array(
                'workfactor' => 12,
                'salt' => '%$gn4iwgjeF>E:T45t543mfda54n'
            ),
            'namespace' => 'Zemit',
            'modules' => array(
                'api',
                'frontend',
                'backend'
            ),
            'application' => array(
                
                // defaults
                'controllersDir' => $appPath . 'modules/frontend/controllers/',
                'modelsDir' => $appPath . 'modules/api/models/',
                'viewsDir' => $appPath . 'modules/frontend/views/',
                'pluginsDir' => $appPath . 'library/zemit/plugins/',
                'helpersDir' => $appPath . 'library/zemit/helpers/',
                'libraryDir' => $appPath . 'library/',
                'configDir' => $appPath . 'config/',
                'modulesDir' => $appPath . 'modules/',
                
                // private
                'cacheDir' => $appPath . '../private/cache/',
                'logsDir' => $appPath . '../private/logs/',
                'backupsDir' => $appPath . '../private/backups/',
                'filesDir' => $appPath . '../private/files/',
                'trashDir' => $appPath . '../private/trash/',
                'sqlDir' => $appPath . '../private/sql/',
                'migrationsDir' => $appPath . '../private/migrations/',
                'vendorDir' => $appPath . '../vendor/',
                
                // project
                'baseDir' => $appPath,
                'projectDir' => realpath($appPath . '../'),
                'baseUri' => '',
            ),
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
            'mail' => array(
                'driver' => 'sendmail',
                'sendmail' => '/usr/sbin/sendmail -bs',
                'from' => array(
                    'email' => 'no-reply@zemit.dev.nuagerie.com',
                    'name' => 'Zemit | McGill'
                ),
                'bcc' => array(
                    'no-reply@zemit.dev.nuagerie.com' => 'Zemit | McGill',
                ),
                'viewsDir' => $appPath . 'modules/frontend/views/',
            ),
            'client' => array(),
        ));
        if (!empty($config)) {
            $this->merge(new PhalconConfig($config));
        }
    }
    
    public function mergeEnvConfig($env = APPLICATION_ENV)
    {
        $configFile = $this->application->configDir . 'env/config.' . $env . '.php';
        if (file_exists($configFile)) {
            $envConfig = require_once $configFile;
            if (!empty($envConfig)) {
                $this->merge(new PhalconConfig(is_callable($envConfig) ? $envConfig() : $envConfig));
            }
        }
        return $this;
    }
}

if (php_sapi_name() === 'cli') {
    $devtoolConfig = new Config();
    return $devtoolConfig->mergeEnvConfig();
}