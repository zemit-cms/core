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

use Zemit\Filter;
use Zemit\Filters;
use Zemit\Locale;
use Zemit\Providers;
use Zemit\Utils\Env;
use Phalcon\Config as PhalconConfig;
use PDO;
use Zemit\Version;
use Zemit\Provider;

class Config extends PhalconConfig
{
    public function defineConst()
    {
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', Env::get('APPLICATION_ENV', 'development'));
        defined('CORE_PATH') || define('CORE_PATH', Env::get('CORE_PATH', mb_substr(__DIR__, 0, mb_strlen(basename(__DIR__)) * -1)));
        defined('PRIVATE_PATH') || define('PRIVATE_PATH', Env::get('APP_PRIVATE_PATH', APP_PATH . '/private/'));
    }
    
    public function __construct($config = [])
    {
        $this->defineConst();
        
        parent::__construct([
            
            /**
             * Core only settings
             */
            'core' => [
                'version' => Version::get(),
                'package' => 'zemit-official',
                'modules' => [
                    \Zemit\Mvc\Module::NAME_FRONTEND => [
                        'className' => \Zemit\Modules\Frontend\Module::class,
                        'path' => CORE_PATH . 'Modules/Frontend/Module.php',
                    ],
                    \Zemit\Mvc\Module::NAME_BACKEND => [
                        'className' => \Zemit\Modules\Backend\Module::class,
                        'path' => CORE_PATH . 'Modules/Backend/Module.php',
                    ],
                    \Zemit\Mvc\Module::NAME_API => [
                        'className' => \Zemit\Modules\Api\Module::class,
                        'path' => CORE_PATH . 'Modules/Api/Module.php',
                    ],
                    \Zemit\Mvc\Module::NAME_CLI => [
                        'className' => \Zemit\Modules\Cli\Module::class,
                        'path' => CORE_PATH . 'Modules/Cli/Module.php',
                    ],
                ],
                'dir' => [
                    'base' => CORE_PATH,
                    'locales' => CORE_PATH . 'Locales',
                    'modules' => CORE_PATH . 'Modules',
                ],
            ],
            
            /**
             * Application configuration
             */
            'app' => [
                'namespace' => Env::get('APP_NAMESPACE', 'Zemit'), // Namespace of your application
                'version' => Env::get('APP_VERSION', date('Ymd')), // allow to set and force a specific version
                'maintenance' => Env::get('APP_MAINTENANCE', false), // Set true to force the maintenance page
                'env' => Env::get('APP_ENV', Env::get('APPLICATION_ENV', null)), // Set the current environnement
                'debug' => Env::get('APP_DEBUG', false), // Set true to display debug
                'cache' => Env::get('APP_CACHE', false), // Set true to activate the cache
                'minify' => Env::get('APP_MINIFY', false), // Set true to activate minifying
                'copyright' => Env::get('APP_COPYRIGHT', false), // Set true to activate the cache
                'profiler' => Env::get('APP_PROFILER', false), // Set true to return the profiler
                'logger' => Env::get('APP_LOGGER', false), // Set true to log database transactions
                'uri' => Env::get('APP_URI', '/'), // Base URI of your application
                'staticUri' => Env::get('APP_STATIC_URI', '/'), // Base URI of your application
                'encoding' => Env::get('APP_ENCODING', 'UTF-8'), // allow to set encoding to use with the application
                'timezone' => Env::get('APP_TIMEZONE', 'America/Montreal'), // allow to set timezone to use with the application
                'timeoutLimit' => Env::get('APP_TIMEOUT_LIMIT', 60), // allow to set timeout limit to use with the application
                'memoryLimit' => Env::get('APP_MEMORY_LIMIT', '256M'), // allow to set timeout limit to use with the application
                'postLimit' => Env::get('APP_POST_LIMIT', '20M'), // allow to set timeout limit to use with the application
                
                'dir' => [
                    // project
                    'root' => Env::get('APP_ROOT_PATH', defined('ROOT_PATH') ? ROOT_PATH : getcwd()),
                    'vendor' => Env::get('APP_VENDOR_PATH', VENDOR_PATH),
                    'app' => Env::get('APP_PATH', APP_PATH . '/'),
                    'public' => Env::get('APP_PUBLIC_PATH', getcwd()),
                    
                    // app
                    'bootstrap' => Env::get('APP_BOOTSTRAP_PATH', APP_PATH . '/Bootstrap/'),
                    'config' => Env::get('APP_CONFIG_PATH', APP_PATH . '/Config/'),
                    'modules' => Env::get('APP_MODULES_PATH', APP_PATH . '/Modules/'),
                    'plugins' => Env::get('APP_PLUGINS_PATH', APP_PATH . '/Plugins/'),
                    'private' => PRIVATE_PATH,
                    
                    // private
                    'cache' => Env::get('APP_CACHE_PATH', PRIVATE_PATH . '/cache/'),
                    'log' => Env::get('APP_LOG_PATH', PRIVATE_PATH . '/log/'),
                    'files' => Env::get('APP_FILE_PATH', PRIVATE_PATH . '/files/'),
                    'trash' => Env::get('APP_TRASH_PATH', PRIVATE_PATH . '/trash/'),
                    'migrations' => Env::get('APP_MIGRATION_PATH', PRIVATE_PATH . '/migrations/'),
                ],
            ],
    
            /**
             * Service Provider Configurations
             */
            'providers' => [
                // abstract => concrete
                Provider\Environment\ServiceProvider::class => Provider\Environment\ServiceProvider::class,
                Provider\Security\ServiceProvider::class => Provider\Security\ServiceProvider::class,
                Provider\Session\ServiceProvider::class => Provider\Session\ServiceProvider::class,
                Provider\Cookies\ServiceProvider::class => Provider\Cookies\ServiceProvider::class,
                
                Provider\Locale\ServiceProvider::class => Provider\Locale\ServiceProvider::class,
                Provider\Translate\ServiceProvider::class => Provider\Translate\ServiceProvider::class,
                Provider\Url\ServiceProvider::class => Provider\Url\ServiceProvider::class,
                Provider\Router\ServiceProvider::class => Provider\Router\ServiceProvider::class,
                Provider\Dispatcher\ServiceProvider::class => Provider\Dispatcher\ServiceProvider::class,
                Provider\VoltTemplate\ServiceProvider::class => Provider\VoltTemplate\ServiceProvider::class,
                Provider\View\ServiceProvider::class => Provider\View\ServiceProvider::class,

                Provider\Profiler\ServiceProvider::class => Provider\Profiler\ServiceProvider::class,
                Provider\Database\ServiceProvider::class => Provider\Database\ServiceProvider::class,
                Provider\Annotations\ServiceProvider::class => Provider\Annotations\ServiceProvider::class,
                Provider\ModelsManager\ServiceProvider::class => Provider\ModelsManager\ServiceProvider::class,
                Provider\ModelsMetadata\ServiceProvider::class => Provider\ModelsMetadata\ServiceProvider::class,
                Provider\ModelsCache\ServiceProvider::class => Provider\ModelsCache\ServiceProvider::class,
                Provider\ViewCache\ServiceProvider::class => Provider\ViewCache\ServiceProvider::class,
                Provider\Mailer\ServiceProvider::class => Provider\Mailer\ServiceProvider::class,
                Provider\Logger\ServiceProvider::class => Provider\Logger\ServiceProvider::class,
                Provider\FileSystem\ServiceProvider::class => Provider\FileSystem\ServiceProvider::class,
                
                Provider\Assets\ServiceProvider::class => Provider\Assets\ServiceProvider::class,
                Provider\Tag\ServiceProvider::class => Provider\Tag\ServiceProvider::class,
                Provider\Filter\ServiceProvider::class => Provider\Filter\ServiceProvider::class,
                Provider\Flash\ServiceProvider::class => Provider\Flash\ServiceProvider::class,
                Provider\Escaper\ServiceProvider::class => Provider\Escaper\ServiceProvider::class,
                Provider\Markdown\ServiceProvider::class => Provider\Markdown\ServiceProvider::class,
                Provider\Utils\ServiceProvider::class => Provider\Utils\ServiceProvider::class,
                
                // lib
                Provider\V8js\ServiceProvider::class => Provider\V8js\ServiceProvider::class,
                Provider\Captcha\ServiceProvider::class => Provider\Captcha\ServiceProvider::class,
                Provider\Gravatar\ServiceProvider::class => Provider\Gravatar\ServiceProvider::class,
//                Snowair\Debugbar\ServiceProvider::class => \Snowair\Debugbar\ServiceProvider::class,
            ],
            
            'logger' => [
                'path' => Env::get('APP_LOGGER_PATH', PRIVATE_PATH . '/log/'),
                'format' => Env::get('APP_LOGGER_FORMAT', '[%date%][%type%] %message%'),
                'date' => 'Y-m-d H:i:s',
                'level' => Env::get('APP_LOGGER_LEVEL', 'info'),
                'filename' => Env::get('APP_LOGGER_DEFAULT_FILENAME', 'application'),
            ],
            
            /**
             * Default filters
             */
            'filters' => [
                Filter::FILTER_MD5 => Filters\Md5::class,
                Filter::FILTER_JSON => Filters\Json::class,
                Filter::FILTER_IPV4 => Filters\IPv4::class,
                Filter::FILTER_IPV6 => Filters\IPv6::class,
            ],
            
            /**
             * Default modules
             */
            'modules' => [
                \Zemit\Mvc\Module::NAME_FRONTEND => [
                    'className' => \Zemit\Modules\Frontend\Module::class,
                    'path' => CORE_PATH . 'Modules/Frontend/Module.php',
                ],
                \Zemit\Mvc\Module::NAME_BACKEND => [
                    'className' => \Zemit\Modules\Backend\Module::class,
                    'path' => CORE_PATH . 'Modules/Backend/Module.php',
                ],
                \Zemit\Mvc\Module::NAME_API => [
                    'className' => \Zemit\Modules\Api\Module::class,
                    'path' => CORE_PATH . 'Modules/Api/Module.php',
                ],
                \Zemit\Mvc\Module::NAME_CLI => [
                    'className' => \Zemit\Modules\Cli\Module::class,
                    'path' => CORE_PATH . 'Modules/Cli/Module.php',
                ],
                /**
                 * @TODO support this way too
                 */
//                \Zemit\Mvc\Module::NAME_FRONTEND => \Zemit\Modules\Frontend\Module::class,
//                \Zemit\Mvc\Module::NAME_BACKEND => \Zemit\Modules\Backend\Module::class,
//                \Zemit\Mvc\Module::NAME_API => \Zemit\Modules\Api\Module::class,
//                \Zemit\Mvc\Module::NAME_CLI => \Zemit\Modules\Cli\Module::class,
            ],
            
            /**
             * Default router settings
             */
            'router' => [
                'defaults' => [
                    'namespace' => Env::get('ROUTER_DEFAULT_NAMESPACE', 'Zemit\\Modules\\Frontend\\Controllers'),
                    'module' => Env::get('ROUTER_DEFAULT_MODULE', 'frontend'),
                    'controller' => Env::get('ROUTER_DEFAULT_CONTROLLER', 'index'),
                    'action' => Env::get('ROUTER_DEFAULT_ACTION', 'index'),
                ],
                'notFound' => [
                    'controller' => Env::get('ROUTER_NOTFOUND_CONTROLLER', 'errors'),
                    'action' => Env::get('ROUTER_NOTFOUND_ACTION', 'notFound'),
                ],
            ],
            
            'gravatar' => [
                'default_image' => Env::get('GRAVATAR_DEFAULT_IMAGE', 'identicon'),
                'size' => Env::get('GRAVATAR_SIZE', 24),
                'rating' => Env::get('GRAVATAR_RATING', 'pg'),
                'use_https' => Env::get('GRAVATAR_HTPPS', true),
            ],
            
            'reCaptcha' => [
                'siteKey' => Env::get('RECAPTCHA_KEY'),
                'secret' => Env::get('RECAPTCHA_SECRET'),
            ],
            
            /**
             * Default local settings
             */
            'locale' => [
                'default' => Env::get('LOCALE_DEFAULT', 'en'),
                'sessionKey' => Env::get('LOCALE_SESSION_KEY', 'zemit-locale'),
                'mode' => Env::get('LOCALE_MODE', Locale::MODE_SESSION_GEOIP),
                'allowed' => explode(',', Env::get('LOCALE_ALLOWED', 'en,en_US,fr,fr_FR,fr_CA')),
            ],
            
            /**
             * Default Session Configuration
             */
            'session' => [
                'default' => Env::get('SESSION_DRIVER'),
                'drivers' => [
                    'memcached' => [
                        'adapter' => 'Libmemcached',
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                        // Client options must be instance of array
                        'client' => [],
                    ],
                    'redis' => [
                        'adapter' => 'Redis',
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                        'persistent' => true,
                    ],
                    'file' => [
                        'adapter' => 'Files',
                    ],
                ],
                'prefix' => Env::get('SESSION_PREFIX', 'zemit_session_'),
                'uniqueId' => Env::get('SESSION_UNIQUE_ID', 'zemit_'),
                'lifetime' => Env::get('SESSION_LIFETIME', 3600),
            ],
            
            /**
             * Default translater settings
             */
            'translate' => [
                'locale' => Env::get('TRANSLATE_LOCALE', 'en_US.utf8'),
                'defaultDomain' => Env::get('TRANSLATE_DEFAULT_DOMAIN', 'messages'),
                'category' => Env::get('TRANSLATE_CATEGORY', LC_MESSAGES),
                'directory' => [
                    Env::get('TRANSLATE_DEFAULT_DOMAIN', 'messages') => Env::get('TRANSLATE_DEFAULT_PATH', CORE_PATH . 'Locales'),
                ],
            ],
            
            /**
             * Default module/plugin structure
             */
            'module' => [
                'dir' => [
                    // default
                    'modules' => Env::get('MODULE_DIR_MODULES', 'Modules/'),
                    'controllers' => Env::get('MODULE_DIR_CONTROLLER', 'Controllers/'),
                    'tasks' => Env::get('MODULE_DIR_TASKS', 'Tasks/'),
                    'models' => Env::get('MODULE_DIR_MODELS', 'Models/'),
                    'views' => Env::get('MODULE_DIR_VIEWS', 'Views/'),
                    'bootstrap' => Env::get('MODULE_DIR_BOOTSTRAP', 'Bootstrap/'),
                    'locales' => Env::get('MODULE_DIR_LOCALES', 'Locales/'),
                    'config' => Env::get('MODULE_DIR_CONFIG', 'Config/'),
                    
                    // private
                    'migrations' => Env::get('MODULE_DIR_MIGRATION', 'Private/migrations/'),
                    'cache' => Env::get('MODULE_DIR_MIGRATION', 'Private/migrations/'),
                    'logs' => Env::get('MODULE_DIR_LOGS', 'Private/migrations/'),
                    'backups' => Env::get('MODULE_DIR_BACKUPS', 'Private/backups/'),
                    'files' => Env::get('MODULE_DIR_FILES', 'Private/files/'),
                    'trash' => Env::get('MODULE_DIR_TRASH', 'Private/trash/'),
                ],
            ],
            
            /**
             * Default security settings
             */
            'security' => [ // phalcon security config
                'workfactor' => Env::get('SECURITY_WORKFACTOR', 12), // workfactor for the phalcon security service
                'salt' => Env::get('SECURITY_SALT', 'ZEMIT_CORE_DEFAULT_SALT') // salt for the phalcon security service
            ],
            
            /**
             * Cache drivers configs
             */
            'cache' => [
                'default' => Env::get('CACHE_DRIVER', 'file'),
                'views' => Env::get('VIEW_CACHE_DRIVER', 'views'),
                'drivers' => [
                    'apc' => [
                        'adapter' => 'Apc',
                    ],
                    'memory' => [
                        'adapter' => 'Memory',
                    ],
                    'memcached' => [
                        'adapter' => 'Libmemcached',
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => 'Redis',
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                    ],
                    'file' => [
                        'adapter' => 'File',
                        'cacheDir' => PRIVATE_PATH . '/cache/data/',
                    ],
                    'views' => [
                        'adapter' => 'File',
                        'cacheDir' => PRIVATE_PATH . '/cache/views/',
                    ],
                ],
                'prefix' => Env::get('CACHE_PREFIX', 'zemit_cache_'),
                'lifetime' => Env::get('CACHE_LIFETIME', 86400),
            ],
            
            /**
             * Metadata Configuration
             */
            'metadata' => [
                'default' => Env::get('METADATA_DRIVER', 'memory'),
                'drivers' => [
                    'apc' => [
                        'adapter' => 'Apc',
                    ],
                    'memcached' => [
                        'adapter' => 'Libmemcached',
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                    ],
                    'file' => [
                        'adapter' => 'Files',
                        'metaDataDir' => PRIVATE_PATH . '/cache/metadata/',
                    ],
                    'redis' => [
                        'adapter' => 'Redis',
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                    ],
                    'memory' => [
                        'adapter' => 'Memory',
                    ],
                    'session' => [
                        'adapter' => 'Session',
                    ],
                ],
                'prefix' => Env::get('METADATA_PREFIX', 'zemit_metadata_'),
                'lifetime' => Env::get('METADATA_LIFETIME', 172800),
            ],
            
            /**
             * Annotations Configuration
             */
            'annotations' => [
                'default' => Env::get('ANNOTATIONS_DRIVER', 'memory'),
                'drivers' => [
                    'apc' => [
                        'adapter' => 'Apc',
                    ],
                    'file' => [
                        'adapter' => 'Files',
                        'annotationsDir' => PRIVATE_PATH . '/cache/annotations',
                    ],
                    'memory' => [
                        'adapter' => 'Memory',
                    ],
                ],
                'prefix' => Env::get('ANNOTATIONS_PREFIX', 'zemit_annotations_'),
                'lifetime' => Env::get('ANNOTATIONS_LIFETIME', 86400),
            ],
            
            /**
             * Database configuration
             */
            'database' => [
                'adapter' => Env::get('DATABASE_ADAPTER', 'Mysql'),
                'host' => Env::get('DATABASE_HOST', 'localhost'),
                'username' => Env::get('DATABASE_USERNAME', 'root'),
                'password' => Env::get('DATABASE_PASSWORD', ''),
                'dbname' => Env::get('DATABASE_DBNAME', ''),
                'charset' => Env::get('DATABASE_CHARSET', 'utf8'),
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . Env::get('DATABASE_CHARSET', 'utf8'),
                ],
            ],
            
            /**
             * Mailer configuration
             */
            'mailer' => [
                'driver' => 'sendmail',
                'sendmail' => '/usr/sbin/sendmail -bs',
                'from' => [
                    'email' => 'no-reply@zemit.com',
                    'name' => 'Zemit',
                ],
                'bcc' => [
                    'contat@zemit.com' => 'Zemit',
                ],
                'viewsDir' => APP_PATH . '/Modules/Frontend/Views/',
            ],
            
            /**
             * Cookies
             */
            'cookies' => [
                'useEncryption' => Env::get('COOKIES_USE_ENCRYPTION', true),
                'signKey' => Env::get('COOKIES_SIGN_KEY', ''),
            ],
            
            /**
             * Dotenv
             */
            'dotenv' => [
                'filePath' => '',
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
     *
     * @param null|string $env If null, will fetch the current environement from $this->app->env
     *
     * @return Config $this Return the merged current config
     */
    public function mergeEnvConfig($env = null)
    {
        $configFile = $this->app->dir->config . (isset($env) ? $env : $this->app->env) . '.php';
        
        if (file_exists($configFile)) {
            $envConfig = require_once $configFile;
            if (!empty($envConfig)) {
                $envConfig = is_callable($envConfig) ? $envConfig() : $envConfig;
                if (is_array($envConfig)) {
                    $this->merge(new PhalconConfig($envConfig));
                }
            }
        }
        
        return $this;
    }
}

//if (php_sapi_name() === 'cli') {
//    $devtoolConfig = new Config();
//    return $devtoolConfig->mergeEnvConfig();
//}
