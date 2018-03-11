<?php

namespace Zemit\Core\Bootstrap;

use Zemit\Core\Locale;
use Zemit\Core\Utils\Env;
use Phalcon\Config as PhalconConfig;
use PDO;

class Config extends PhalconConfig
{
    
    public function __construct($config = array())
    {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', Env::get('APPLICATION_ENV', 'development'));
        defined('CORE_PATH') || define('CORE_PATH', Env::get('CORE_PATH', mb_substr(__DIR__, 0, mb_strlen(basename(__DIR__))*-1)));
        defined('PRIVATE_PATH') || define('PRIVATE_PATH', Env::get('APP_PRIVATE_PATH', APP_PATH . '/private/'));
        
        parent::__construct([
    
            /**
             * Core only settings
             */
            'core' => [
                'version' => '0.1.1',
                'package' => 'zemit-official',
                'modules' => [
                    'frontend' => [
                        'className' => 'Zemit\\Core\\Frontend\\Module',
                        'path' => CORE_PATH . 'Frontend/Module.php'
                    ],
                    'backend' => [
                        'className' => 'Zemit\\Core\\Backend\\Module',
                        'path' => CORE_PATH . 'Backend/Module.php'
                    ],
                    'api' => [
                        'className' => 'Zemit\\Core\\Api\\Module',
                        'path' => CORE_PATH . 'Api/Module.php'
                    ],
                ],
                'dir' => [
                    'base' => CORE_PATH,
                    'locales' => CORE_PATH . 'Locales',
                ],
            ],
    
            /**
             * Application configuration
             */
            'app' => [
                'namespace' => Env::get('APP_NAMESPACE', 'Zemit'),
                'version' => Env::get('APP_VERSION', date('Ymd')), // allow to set and force a specific version
                'maintenance' => Env::get('APP_MAINTENANCE', false), // Set true to force the maintenance page
                'env' => Env::get('APP_ENV', Env::get('APPLICATION_ENV', null)), // Set the current environnement
                'debug' => Env::get('APP_DEBUG', false), // Set true to display debug
                'cache' => Env::get('APP_CACHE', false), // Set true to activate the cache
                'minify' => Env::get('APP_MINIFY', false), // Set true to activate minifying
                'copyright' => Env::get('APP_COPYRIGHT', false), // Set true to activate the cache
                'profiler' => Env::get('APP_PROFILER', false), // Set true to return the profiler
                'logger' => Env::get('APP_LOGGER', false), // Set true to log database transactions
                'uri' => Env::get('APP_URI', ''),
                'dir' => [
                    // project
                    'root' => Env::get('APP_ROOT_PATH', defined('ROOT_PATH')? ROOT_PATH : getcwd()),
                    'vendor' => Env::get('APP_VENDOR_PATH', VENDOR_PATH),
                    'app' => Env::get('APP_PATH', APP_PATH . '/'),
                    'public' => Env::get('APP_PUBLIC_PATH', getcwd()),
            
                    // app
                    'bootstrap' => Env::get('APP_BOOTSTRAP_PATH', APP_PATH . '/bootstrap/'),
                    'config' => Env::get('APP_CONFIG_PATH', APP_PATH . '/config/'),
                    'modules' => Env::get('APP_MODULE_PATH', APP_PATH . '/modules/'),
                    'plugins' => Env::get('APP_PLUGINS_PATH', APP_PATH . '/plugins/'),
                    'private' => PRIVATE_PATH,
            
                    // private
                    'cache' => Env::get('APP_CACHE_PATH', PRIVATE_PATH . '/cache/'),
                    'log' => Env::get('APP_LOG_PATH', PRIVATE_PATH . '/log/'),
                    'files' => Env::get('APP_FILE_PATH', PRIVATE_PATH . '/files/'),
                    'trash' => Env::get('APP_TRASH_PATH', PRIVATE_PATH . '/trash/'),
                    'migrations' => Env::get('APP_MIGRATION_PATH', PRIVATE_PATH . '/migrations/'),
                ]
            ],
            
            /**
             * Default security settings
             */
            'security' => [ // phalcon security config
                'workfactor' => Env::get('SECURITY_WORKFACTOR', 12), // workfactor for the phalcon security service
                'salt' => Env::get('SECURITY_SALT', 'ZEMIT_CORE_DEFAULT_SALT') // salt for the phalcon security service
            ],
            
            /**
             * Default modules
             */
            'modules' => [
                'frontend' => [
                    'className' => 'Zemit\\Core\\Frontend\\Module',
                    'path' => CORE_PATH . 'Frontend/Module.php'
                ],
                'backend' => [
                    'className' => 'Zemit\\Core\\Backend\\Module',
                    'path' => CORE_PATH . 'Backend/Module.php'
                ],
                'api' => [
                    'className' => 'Zemit\\Core\\Api\\Module',
                    'path' => CORE_PATH . 'Api/Module.php'
                ],
            ],
    
            /**
             * Default router settings
             */
            'router' => [
                'defaults' => [
                    'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
                    'module' => 'frontend',
                    'controller' => 'index',
                    'action' => 'index'
                ],
                'notFound' => [
                    'controller' => 'errors',
                    'action' => 'notFound'
                ]
            ],
    
            /**
             * Default local settings
             */
            'locale' => [
                'default' => Env::get('LOCALE_DEFAULT', 'en'),
                'sessionKey' => Env::get('LOCALE_SESSION_KEY', 'zemit-locale'),
                'mode' => Env::get('LOCALE_MODE', Locale::MODE_SESSION_GEOIP),
                'allowed' => explode(',', Env::get('LOCALE_ALLOWED', 'en,en_US'))
            ],
    
            /**
             * Default translater settings
             */
            'translate' => [
                'locale' => Env::get('TRANSLATE_LOCALE', 'en_US.utf8'),
                'defaultDomain' => Env::get('TRANSLATE_DEFAULT_DOMAIN', 'messages'),
                'category' => Env::get('TRANSLATE_CATEGORY', LC_MESSAGES),
                'directory' => [
                    Env::get('TRANSLATE_DEFAULT_DOMAIN', 'messages') => Env::get('TRANSLATE_DEFAULT_PATH', CORE_PATH . 'Locales')
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
             * Database configuration
             */
            'database' => [
                'adapter' => 'Mysql',
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => '',
                'charset' => 'utf8',
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                ]
            ],
    
            /**
             * Mailer configuration
             */
            'mail' => [
                'driver' => 'sendmail',
                'sendmail' => '/usr/sbin/sendmail -bs',
                'from' => [
                    'email' => 'no-reply@zemit.com',
                    'name' => 'Zemit'
                ],
                'bcc' => [
                    'contat@zemit.com' => 'Zemit',
                ],
                'viewsDir' => APP_PATH . '/modules/frontend/views/',
            ],
    
            /**
             * Client config to passe to front-end
             */
            'client' => [],
        ]);
        if (!empty($config)) {
            $this->merge(new PhalconConfig($config));
        }
    }
    
    /**
     * Merge the specified environment config with this one
     * This should be used to overwrite specific values only
     * @param null|string $env If null, will fetch the current environement from $this->app->env
     * @return Config $this Return the merged current config
     */
    public function mergeEnvConfig($env = null)
    {
        $configFile = $this->app->dir->config . 'env/config.' . (isset($env)? $env : $this->app->env) . '.php';
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