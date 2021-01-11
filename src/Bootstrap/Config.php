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

use PDO;
use Zemit\Filter;
use Zemit\Filters;
use Zemit\Locale;
use Zemit\Models\User;
use Zemit\Modules\Api\Controllers\UserController;
use Zemit\Modules\Cli\Tasks\CacheTask;
use Zemit\Modules\Cli\Tasks\CronTask;
use Zemit\Modules\Frontend\Controllers\ErrorController;
use Zemit\Modules\Frontend\Controllers\IndexController;
use Zemit\Modules\Frontend\Controllers\TestController;
use Zemit\Modules\Oauth2\Controllers\FacebookController;
use Zemit\Modules\Oauth2\Controllers\GoogleController;
use Zemit\Mvc\Controller\Behavior\Model\Create;
use Zemit\Mvc\Controller\Behavior\Model\Delete;
use Zemit\Mvc\Controller\Behavior\Model\Restore;
use Zemit\Mvc\Controller\Behavior\Model\Update;
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipWhiteList;
use Zemit\Providers;
use Zemit\Utils\Env;
use Zemit\Version;
use Zemit\Provider;
use Phalcon\Config as PhalconConfig;

/**
 * Class Config
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Bootstrap
 */
class Config extends PhalconConfig
{
    public function defineConst()
    {
        // @todo remove this
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        
        defined('VENDOR_PATH') || define('VENDOR_PATH', Env::get('ROOT_PATH', 'vendor/'));
        defined('ROOT_PATH') || define('ROOT_PATH', Env::get('ROOT_PATH', null));
        defined('APP_PATH') || define('APP_PATH', Env::get('APP_PATH', null));
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', Env::get('APPLICATION_ENV', 'development'));
        defined('CORE_PATH') || define('CORE_PATH', Env::get('CORE_PATH', mb_substr(__DIR__, 0, mb_strlen(basename(__DIR__)) * -1)));
        defined('PRIVATE_PATH') || define('PRIVATE_PATH', Env::get('APP_PRIVATE_PATH', constant('APP_PATH') . '/private/'));
    }
    
    /**
     * Config constructor.
     * {@inheritDoc}
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->defineConst();
        
        parent::__construct([
            
            /**
             * Core only settings
             */
            'core' => [
                'name' => 'Zemit Core',
                'version' => Version::get(),
                'package' => 'zemit-cms',
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
                    \Zemit\Mvc\Module::NAME_OAUTH2 => [
                        'className' => \Zemit\Modules\Oauth2\Module::class,
                        'path' => CORE_PATH . 'Modules/Oauth2/Module.php',
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
                'logger' => Env::get('APP_LOGGER', false), // Set true to enable logging
                'uri' => Env::get('APP_URI', '/'), // Base URI of your application
                'staticUri' => Env::get('APP_STATIC_URI', '/'), // Base URI of your application
                'encoding' => Env::get('APP_ENCODING', 'UTF-8'), // allow to set encoding to use with the application
                'timezone' => Env::get('APP_TIMEZONE', 'America/Montreal'), // allow to set timezone to use with the application
                'timeoutLimit' => Env::get('APP_TIMEOUT_LIMIT', 60), // allow to set timeout limit to use with the application
                'memoryLimit' => Env::get('APP_MEMORY_LIMIT', '256M'), // allow to set timeout limit to use with the application
                'postLimit' => Env::get('APP_POST_LIMIT', '20M'), // allow to set timeout limit to use with the application
                'sendEmail' => Env::get('APP_SEND_EMAIL', false), // allow to send real email or not
                
                'dir' => [
                    // project
                    'root' => Env::get('APP_ROOT_PATH', defined('ROOT_PATH') ? ROOT_PATH ?: getcwd() : getcwd()),
                    'vendor' => Env::get('APP_VENDOR_PATH', VENDOR_PATH),
                    'app' => Env::get('APP_PATH', APP_PATH . '/'),
                    'public' => Env::get('APP_PUBLIC_PATH', getcwd()),
                    
                    // app
                    'bootstrap' => Env::get('APP_BOOTSTRAP_PATH', APP_PATH . '/Bootstrap/'),
                    'common' => Env::get('APP_COMMON_PATH', APP_PATH . '/Common/'),
                    'config' => Env::get('APP_CONFIG_PATH', APP_PATH . '/Config/'),
                    'modules' => Env::get('APP_MODULES_PATH', APP_PATH . '/Modules/'),
                    'plugins' => Env::get('APP_PLUGINS_PATH', APP_PATH . '/Plugins/'),
                    'private' => PRIVATE_PATH,
                    
                    // private
                    'cache' => Env::get('APP_CACHE_PATH', PRIVATE_PATH . '/cache/'),
                    'log' => Env::get('APP_LOG_PATH', PRIVATE_PATH . '/log/'),
                    'files' => Env::get('APP_FILE_PATH', PRIVATE_PATH . '/files/'),
                    'trash' => Env::get('APP_TRASH_PATH', PRIVATE_PATH . '/trash/'),
                    'tmp' => Env::get('APP_TMP_PATH', PRIVATE_PATH . '/tmp/'),
                    'migrations' => Env::get('APP_MIGRATION_PATH', PRIVATE_PATH . '/migrations/'),
                ],
            ],
            
            /**
             * Debug Configuration
             */
            'debug' => [
                'enable' => Env::get('DEBUG_ENABLE', false),
                'exception' => Env::get('DEBUG_EXCEPTION', true),
                'lowSeverity' => Env::get('DEBUG_LOW_SEVERITY', true),
                'showFiles' => Env::get('DEBUG_SHOW_FILES', true),
                'showBackTrace' => Env::get('DEBUG_SHOW_BACKTRACE', true),
                'showFileFragment' => Env::get('DEBUG_SHOW_FRAGMENT', true),
                'uri' => Env::get('DEBUG_URI'),
                'blacklist' => [
                    'server' => [
                        'PASS',
                        'PASSWD',
                        'PASSWORD',
                        'TOKEN',
                        'HASH',
                        'DB_PASS',
                        'DB_PASSWD',
                        'DB_PASSWORD',
                        'DATABASE_PASS',
                        'DATABASE_PASSWD',
                        'DATABASE_PASSWORD',
                        'SECURITY_WORKFACTOR',
                        'SECURITY_SALT',
                        'PASSPHRASE',
                        'SECRET',
                        'API_SECRET',
                        'API_KEY',
                    ],
                ],
            ],
            
            /**
             * Identity Provider Configuration
             */
            'identity' => [
                'userClass' => Env::get('IDENTITY_USER_CLASS', \Zemit\Models\User::class),
                'emailClass' => Env::get('IDENTITY_EMAIL_CLASS', \Zemit\Models\Email::class),
                'sessionClass' => Env::get('IDENTITY_SESSION_CLASS', \Zemit\Models\Session::class),
                'sessionKey' => Env::get('IDENTITY_SESSION_KEY', 'zemit-identity'),
            ],
            
            /**
             *
             */
            'models' => [
                
                // System
                \Zemit\Models\Backup::class => \Zemit\Models\Backup::class,
                \Zemit\Models\Audit::class => \Zemit\Models\Audit::class,
                \Zemit\Models\AuditDetail::class => \Zemit\Models\AuditDetail::class,
                \Zemit\Models\Log::class => \Zemit\Models\Log::class,
                \Zemit\Models\Email::class => \Zemit\Models\Email::class,
                \Zemit\Models\Job::class => \Zemit\Models\Job::class,
                \Zemit\Models\File::class => \Zemit\Models\File::class,
                \Zemit\Models\Session::class => \Zemit\Models\Session::class,
                
                # system misc
                \Zemit\Models\Locale::class => \Zemit\Models\Locale::class,
                \Zemit\Models\Translation::class => \Zemit\Models\Translation::class,
                \Zemit\Models\Setting::class => \Zemit\Models\Setting::class,
                \Zemit\Models\Template::class => \Zemit\Models\Template::class,
                
                // Workspace
                \Zemit\Models\Workspace::class => \Zemit\Models\Workspace::class,
                \Zemit\Models\WorkspaceProject::class => \Zemit\Models\WorkspaceProject::class,
                \Zemit\Models\WorkspaceUser::class => \Zemit\Models\WorkspaceUser::class,
                
                // Project
                \Zemit\Models\Project::class => \Zemit\Models\Project::class,
                \Zemit\Models\ProjectUser::class => \Zemit\Models\ProjectUser::class,
                \Zemit\Models\ProjectChannel::class => \Zemit\Models\ProjectChannel::class,
                \Zemit\Models\ProjectEndpoint::class => \Zemit\Models\ProjectEndpoint::class,
                \Zemit\Models\ProjectLocale::class => \Zemit\Models\ProjectLocale::class,
                
                // User
                \Zemit\Models\Profile::class => \Zemit\Models\Profile::class,
                \Zemit\Models\User::class => \Zemit\Models\User::class,
                \Zemit\Models\UserType::class => \Zemit\Models\UserType::class,
                \Zemit\Models\UserGroup::class => \Zemit\Models\UserGroup::class,
                \Zemit\Models\UserRole::class => \Zemit\Models\UserRole::class,
                \Zemit\Models\UserFeature::class => \Zemit\Models\UserFeature::class,
                
                // Role
                \Zemit\Models\Role::class => \Zemit\Models\Role::class,
                \Zemit\Models\RoleRole::class => \Zemit\Models\RoleRole::class,
                \Zemit\Models\RoleFeature::class => \Zemit\Models\RoleFeature::class,
                
                // Group
                \Zemit\Models\Group::class => \Zemit\Models\Group::class,
                \Zemit\Models\GroupRole::class => \Zemit\Models\GroupRole::class,
                \Zemit\Models\GroupType::class => \Zemit\Models\GroupType::class,
                \Zemit\Models\GroupFeature::class => \Zemit\Models\GroupFeature::class,
                
                // Type
                \Zemit\Models\Type::class => \Zemit\Models\Type::class,
                
                // Feature
                \Zemit\Models\Feature::class => \Zemit\Models\Feature::class,
                
                // Zemit
                \Zemit\Models\Permission::class => \Zemit\Models\Permission::class,
                \Zemit\Models\Flow::class => \Zemit\Models\Flow::class,
                \Zemit\Models\FlowAction::class => \Zemit\Models\FlowAction::class,
                \Zemit\Models\Field::class => \Zemit\Models\Field::class,
            ],
            
            /**
             * Service Provider Configuration
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
                Provider\Request\ServiceProvider::class => Provider\Request\ServiceProvider::class,
                Provider\Router\ServiceProvider::class => Provider\Router\ServiceProvider::class,
                Provider\Dispatcher\ServiceProvider::class => Provider\Dispatcher\ServiceProvider::class,
                Provider\VoltTemplate\ServiceProvider::class => Provider\VoltTemplate\ServiceProvider::class,
                Provider\View\ServiceProvider::class => Provider\View\ServiceProvider::class,
                
                Provider\Profiler\ServiceProvider::class => Provider\Profiler\ServiceProvider::class,
                Provider\Database\ServiceProvider::class => Provider\Database\ServiceProvider::class,
                Provider\DatabaseReadOnly\ServiceProvider::class => Provider\DatabaseReadOnly\ServiceProvider::class,
                Provider\Annotations\ServiceProvider::class => Provider\Annotations\ServiceProvider::class,
                Provider\ModelsManager\ServiceProvider::class => Provider\ModelsManager\ServiceProvider::class,
                Provider\ModelsMetadata\ServiceProvider::class => Provider\ModelsMetadata\ServiceProvider::class,
                Provider\ModelsCache\ServiceProvider::class => Provider\ModelsCache\ServiceProvider::class,
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
                
                // oauth2
                Provider\Identity\ServiceProvider::class => Provider\Identity\ServiceProvider::class,
                Provider\Oauth2Facebook\ServiceProvider::class => Provider\Oauth2Facebook\ServiceProvider::class,
                Provider\Oauth2Google\ServiceProvider::class => Provider\Oauth2Google\ServiceProvider::class,
                
                // lib
                Provider\OCR\ServiceProvider::class => Provider\OCR\ServiceProvider::class,
                Provider\Jwt\ServiceProvider::class => Provider\Jwt\ServiceProvider::class,
                Provider\V8js\ServiceProvider::class => Provider\V8js\ServiceProvider::class,
                Provider\Captcha\ServiceProvider::class => Provider\Captcha\ServiceProvider::class,
                Provider\Gravatar\ServiceProvider::class => Provider\Gravatar\ServiceProvider::class,
                Provider\Clamav\ServiceProvider::class => Provider\Clamav\ServiceProvider::class,
//                Snowair\Debugbar\ServiceProvider::class => \Snowair\Debugbar\ServiceProvider::class,
            ],
            
            /**
             * Logger Configuration
             */
            'logger' => [
                'enable' => Env::get('LOGGER_ENABLE', false),
                
                'error' => Env::get('LOGGER_ERROR', false),
                'database' => Env::get('LOGGER_DATABASE', false),
                'dispatcher' => Env::get('LOGGER_DISPATCHER', false),
                'profiler' => Env::get('LOGGER_PROFILER', false),
                'mailer' => Env::get('LOGGER_MAILER', false),
                'cron' => Env::get('LOGGER_CRON', false),
                'auth' => Env::get('LOGGER_AUTH', false),
                
                'driver' => explode(',', Env::get('LOGGER_DRIVER', 'noop')),
                'drivers' => [
                    'noop' => [
                        'adapter' => \Phalcon\Logger\Adapter\Noop::class,
                    ],
                    'stream' => [
                        'adapter' => \Phalcon\Logger\Adapter\Stream::class,
                    ],
                    'syslog' => [
                        'adapter' => \Phalcon\Logger\Adapter\Syslog::class,
                    ],
                ],
                'default' => [
                    'path' => Env::get('LOGGER_PATH', PRIVATE_PATH . '/log/'),
                    'format' => Env::get('LOGGER_FORMAT', '[%date%][%type%] %message%'),
                    'date' => Env::get('LOGGER_DATE', 'Y-m-d H:i:s'),
                    'filename' => Env::get('LOGGER_DEFAULT_FILENAME', 'zemit'),
                ],
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
             * @todo change this to class => [class => '', path => '']
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
                \Zemit\Mvc\Module::NAME_OAUTH2 => [
                    'className' => \Zemit\Modules\Oauth2\Module::class,
                    'path' => CORE_PATH . 'Modules/Oauth2/Module.php',
                ],
                /**
                 * @TODO support this way too
                 */
//                \Zemit\Modules\Frontend\Module::class => \Zemit\Modules\Frontend\Module::class,
//                \Zemit\Modules\Backend\Module::class => \Zemit\Modules\Backend\Module::class,
//                \Zemit\Modules\Api\Module::class => \Zemit\Modules\Api\Module::class,
//                \Zemit\Modules\Cli\Module::class => \Zemit\Modules\Cli\Module::class,
            ],
            
            /**
             * Default router settings
             */
            'router' => [
                'defaults' => [
                    'namespace' => Env::get('ROUTER_DEFAULT_NAMESPACE', 'Zemit\\Modules\\Frontend\\Controllers'),
                    'module' => Env::get('ROUTER_DEFAULT_MODULE', 'frontend'),
                    'controller' => Env::get('ROUTER_DEFAULT_CONTROLLER', 'index'),
                    'task' => Env::get('ROUTER_DEFAULT_CONTROLLER', 'index'),
                    'action' => Env::get('ROUTER_DEFAULT_ACTION', 'index'),
                ],
                'notFound' => [
                    'namespace' => Env::get('ROUTER_NOTFOUND_NAMESPACE', null),
                    'module' => Env::get('ROUTER_NOTFOUND_MODULE', null),
                    'controller' => Env::get('ROUTER_NOTFOUND_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_NOTFOUND_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_NOTFOUND_ACTION', 'notFound'),
                ],
                'fatal' => [
                    'namespace' => Env::get('ROUTER_FATAL_NAMESPACE', null),
                    'module' => Env::get('ROUTER_FATAL_MODULE', null),
                    'controller' => Env::get('ROUTER_FATAL_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_FATAL_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_FATAL_ACTION', 'fatal'),
                ],
                'forbidden' => [
                    'namespace' => Env::get('ROUTER_MAINTENANCE_NAMESPACE', null),
                    'module' => Env::get('ROUTER_MAINTENANCE_MODULE', null),
                    'controller' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_MAINTENANCE_ACTION', 'forbidden'),
                ],
                'unauthorized' => [
                    'namespace' => Env::get('ROUTER_MAINTENANCE_NAMESPACE', null),
                    'module' => Env::get('ROUTER_MAINTENANCE_MODULE', null),
                    'controller' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_MAINTENANCE_ACTION', 'unauthorized'),
                ],
                'maintenance' => [
                    'namespace' => Env::get('ROUTER_MAINTENANCE_NAMESPACE', null),
                    'module' => Env::get('ROUTER_MAINTENANCE_MODULE', null),
                    'controller' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_MAINTENANCE_ACTION', 'maintenance'),
                ],
                'error' => [
                    'namespace' => Env::get('ROUTER_ERROR_NAMESPACE', null),
                    'module' => Env::get('ROUTER_ERROR_MODULE', null),
                    'controller' => Env::get('ROUTER_ERROR_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_ERROR_CONTROLLER', 'error'),
                    'action' => Env::get('ROUTER_ERROR_ACTION', 'index'),
                ],
            ],
            
            /**
             * Gravatar Configuration
             */
            'gravatar' => [
                'default_image' => Env::get('GRAVATAR_DEFAULT_IMAGE', 'identicon'),
                'size' => Env::get('GRAVATAR_SIZE', 24),
                'rating' => Env::get('GRAVATAR_RATING', 'pg'),
                'use_https' => Env::get('GRAVATAR_HTPPS', true),
            ],
            
            /**
             * reCaptcha Configuration
             */
            'reCaptcha' => [
                'siteKey' => Env::get('RECAPTCHA_KEY'),
                'secret' => Env::get('RECAPTCHA_SECRET'),
            ],
            
            /**
             * Locale Service Settings
             */
            'locale' => [
                'default' => Env::get('LOCALE_DEFAULT', 'en'),
                'sessionKey' => Env::get('LOCALE_SESSION_KEY', 'zemit-locale'),
                'mode' => Env::get('LOCALE_MODE', Locale::MODE_SESSION_GEOIP),
                'allowed' => explode(',', Env::get('LOCALE_ALLOWED', 'en')),
            ],
            
            /**
             * Translate Service Settings
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
             * Default Session Configuration
             */
            'session' => [
                'driver' => Env::get('SESSION_DRIVER', 'stream'),
                'drivers' => [
                    'stream' => [
                        'adapter' => \Phalcon\Session\Adapter\Stream::class,
                        'savePath' => Env::get('SESSION_STREAM_SAVE_PATH', '/tmp')
                    ],
                    'memcached' => [
                        'adapter' => \Phalcon\Session\Adapter\Libmemcached::class,
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
                        'adapter' => \Phalcon\Session\Adapter\Redis::class,
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                        'auth' => Env::get('REDIS_AUTH', null),
                        'persistent' => Env::get('REDIS_PERSISTENT', 0),
                        'socket' => Env::get('REDIS_SOCKET', null),
                    ],
                    'noop' => [
                        'adapter' => \Phalcon\Session\Adapter\Noop::class,
                    ],
                    'file' => [
                        'adapter' => 'Files',
                    ],
                ],
                'default' => [
                    'prefix' => Env::get('SESSION_PREFIX', 'zemit_session_'),
                    'uniqueId' => Env::get('SESSION_UNIQUE_ID', 'zemit_'),
                    'lifetime' => Env::get('SESSION_LIFETIME', 3600),
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
                'driver' => Env::get('CACHE_DRIVER', 'memory'),
                'drivers' => [
                    'memory' => [
                        'adapter' => \Phalcon\Cache\Adapter\Memory::class,
                    ],
                    'apcu' => [
                        'adapter' => \Phalcon\Cache\Adapter\Apcu::class,
                    ],
                    'file' => [
                        'adapter' => \Phalcon\Cache\Adapter\Stream::class,
                        'cacheDir' => PRIVATE_PATH . '/cache/data/',
                    ],
                    'memcached' => [
                        'adapter' => \Phalcon\Cache\Adapter\Libmemcached::class,
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => \Phalcon\Cache\Adapter\Redis::class,
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                        'auth' => Env::get('REDIS_AUTH', null),
                        'persistent' => Env::get('REDIS_PERSISTENT', null),
                        'socket' => Env::get('REDIS_SOCKET', null),
                    ],
                ],
                'default' => [
                    'prefix' => Env::get('CACHE_PREFIX', 'zemit_cache_'),
                    'lifetime' => Env::get('CACHE_LIFETIME', 86400),
                    'defaultSerializer' => Env::get('CACHE_DEFAULT_SERIALIZER', 'Php'),
                ],
            ],
            
            /**
             * Metadata Configuration
             */
            'metadata' => [
                'driver' => Env::get('METADATA_DRIVER', 'memory'),
                'drivers' => [
                    'apcu' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Apcu::class,
                    ],
                    'memory' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Memory::class,
                    ],
                    'memcached' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Libmemcached::class,
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                    ],
                    'stream' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Stream::class,
                        'metaDataDir' => PRIVATE_PATH . '/cache/metadata/',
                    ],
                    'redis' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Redis::class,
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                        'auth' => Env::get('REDIS_AUTH', null),
                        'persistent' => Env::get('REDIS_PERSISTENT', null),
                        'socket' => Env::get('REDIS_SOCKET', null),
                    ],
                    'wincache' => [
                        'adapter' => \Phalcon\Mvc\Model\MetaData\Wincache::class,
                    ],
                ],
                'default' => [
                    'lifetime' => Env::get('METADATA_LIFETIME', 172800),
                    'prefix' => Env::get('METADATA_PREFIX', 'zemit_metadata_'),
                ],
            ],
            
            /**
             * Annotations Configuration
             * - Memory
             * - Apcu
             * - Stream
             * - Memcached
             * - Redis
             * - Aerospike
             */
            'annotations' => [
                'default' => Env::get('ANNOTATIONS_DRIVER', 'memory'),
                'drivers' => [
                    'memory' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Memory::class,
                    ],
                    'apcu' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Apcu::class,
                    ],
                    'file' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Stream::class,
                        'annotationsDir' => PRIVATE_PATH . '/cache/annotations',
                    ],
                    'memcached' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Memcached::class,
                        'servers' => [
                            [
                                'host' => Env::get('MEMCACHED_HOST', '127.0.0.1'),
                                'port' => Env::get('MEMCACHED_PORT', 11211),
                                'weight' => Env::get('MEMCACHED_WEIGHT', 100),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Redis::class,
                        'host' => Env::get('REDIS_HOST', '127.0.0.1'),
                        'port' => Env::get('REDIS_PORT', 6379),
                        'index' => Env::get('REDIS_INDEX', 0),
                        'auth' => Env::get('REDIS_AUTH', null),
                        'persistent' => Env::get('REDIS_PERSISTENT', null),
                        'socket' => Env::get('REDIS_SOCKET', null),
                    ],
                    'aerospike' => [
                        'adapter' => \Phalcon\Annotations\Adapter\Aerospike::class,
                    ],
                ],
                'prefix' => Env::get('ANNOTATIONS_PREFIX', 'zemit_annotations_'),
                'lifetime' => Env::get('ANNOTATIONS_LIFETIME', 86400),
            ],
            
            /**
             * Database configuration
             */
            'database' => [
                'default' => Env::get('DATABASE_ADAPTER', 'mysql'),
                'drivers' => [
                    'mysql' => [
                        'adapter' => 'Mysql',
                        'host' => Env::get('DATABASE_HOST', 'localhost'),
                        'port' => Env::get('DATABASE_PORT', 3306),
                        'dbname' => Env::get('DATABASE_DBNAME', ''),
                        'username' => Env::get('DATABASE_USERNAME', 'root'),
                        'password' => Env::get('DATABASE_PASSWORD', ''),
                        'charset' => Env::get('DATABASE_CHARSET', 'utf8'),
                        'options' => [
                            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . Env::get('DATABASE_CHARSET', 'utf8'),
                            \PDO::ATTR_EMULATE_PREPARES => Env::get('DATABASE_PDO_EMULATE_PREPARES', false), // https://stackoverflow.com/questions/10113562/pdo-mysql-use-pdoattr-emulate-prepares-or-not
                            \PDO::ATTR_STRINGIFY_FETCHES => Env::get('DATABASE_PDO_STRINGIFY_FETCHES', false),
                            \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => Env::get('MYSQL_ATTR_SSL_VERIFY_SERVER_CERT', true),
                        ],
                        /**
                         * ReadOnly Configuration
                         */
                        'readOnly' => [
                            'host' => Env::get('DATABASE_READONLY_HOST'),
                            'port' => Env::get('DATABASE_READONLY_PORT'),
                            'dbname' => Env::get('DATABASE_READONLY_DBNAME'),
                            'username' => Env::get('DATABASE_READONLY_USERNAME'),
                            'password' => Env::get('DATABASE_READONLY_PASSWORD'),
                            'charset' => Env::get('DATABASE_READONLY_CHARSET'),
                        ],
                    ],
                ],
            ],
            
            /**
             * Mailer configuration
             */
            'mailer' => [
                'driver' => Env::get('MAILER_DRIVER', 'sendmail'),
                'drivers' => [
                    'mail' => [
                        'driver' => 'mail',
                    ],
                    'sendmail' => [
                        'driver' => 'sendmail',
                        'sendmail' => Env::get('MAILER_SENDMAIL', '/usr/sbin/sendmail -bs'),
                    ],
                    'smtp' => [
                        'driver' => 'smtp',
                        'host' => Env::get('MAILER_SMTP_HOST', 'localhost'),
                        'port' => Env::get('MAILER_SMTP_PORT', 25),
                        'encryption' => Env::get('MAILER_SMTP_ENCRYPTION', ''),
                        'username' => Env::get('MAILER_SMTP_USERNAME', ''),
                        'password' => Env::get('MAILER_SMTP_PASSWORD', ''),
                    ],
                ],
                'default' => [
                    'charset' => Env::get('MAILER_CHARSET', 'utf-8'),
                    'viewsDir' => Env::get('MAILER_VIEWS_DIR', APP_PATH . '/Modules/Frontend/Views/'),
                    'baseUri' => Env::get('MAILER_BASE_URI', null),
                ],
                'from' => [
                    'email' => Env::get('MAILER_FROM_EMAIL', 'zemit@localhost'),
                    'name' => Env::get('MAILER_FROM_NAME', 'Zemit'),
                ],
                'to' => [...explode(',', Env::get('MAILER_TO_EMAIL', ''))],
                'cc' => [...explode(',', Env::get('MAILER_CC_EMAIL', ''))],
                'bcc' => [...explode(',', Env::get('MAILER_BCC_EMAIL', ''))],
            ],
            
            /**
             * Cookies
             */
            'cookies' => [
                'useEncryption' => Env::get('COOKIES_USE_ENCRYPTION', true),
                'signKey' => Env::get('COOKIES_SIGN_KEY', ''),
            ],
            
            /**
             * Oauth2
             */
            'oauth2' => [
                'facebook' => [
                    'clientId' => Env::get('OAUTH2_FACEBOOK_CLIENT_ID'),
                    'clientSecret' => Env::get('OAUTH2_FACEBOOK_CLIENT_SECRET'),
                    'redirectUri' => Env::get('OAUTH2_FACEBOOK_CLIENT_REDIRECT_URI', '/oauth2/facebook/callback'),
                    'graphApiVersion' => Env::get('OAUTH2_FACEBOOK_GRAPH_API_VERSION', 'v2.10'),
                ],
                'google' => [
                    'clientId' => Env::get('OAUTH2_GOOGLE_CLIENT_ID'),
                    'clientSecret' => Env::get('OAUTH2_GOOGLE_CLIENT_SECRET'),
                    'redirectUri' => Env::get('OAUTH2_FACEBOOK_CLIENT_REDIRECT_URI', '/oauth2/google/callback'),
                    'hostedDomain' => Env::get('OAUTH2_FACEBOOK_CLIENT_HOSTED_DOMAIN', null), // optional; used to restrict access to users on your G Suite/Google Apps for Business accounts
                ],
                'instagram' => [
                
                ],
                'linked' => [
                
                ],
                'twitter' => [
                
                ],
                'github' => [
                
                ],
                'apple' => [
                
                ],
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
            
            /**
             * Application permissions
             */
            'permissions' => [
                'features' => [
                    // This feature allow to administer users
                    'user' => [
                        'behaviors' => [
                            UserController::class => [
                                SkipWhiteList::class,
                                SkipIdentityCondition::class,
                                Create::class,
                                Update::class,
                                Delete::class,
                                Restore::class,
                            ]
                        ],
                        'components' => [
                            UserController::class => ['*'],
                            User::class => ['*'],
                        ]
                    ],
                ],
                'roles' => [
                    // Everyone
                    'everyone' => [
                        'behaviors' => [
                        
                        ],
                        'features' => [
                            'user',
                        ],
                        'components' => [
                        
                        ],
                        'controllers' => [
                            IndexController::class => ['*'],
                            ErrorController::class => ['*'],
                            TestController::class => ['*'],
                            UserController::class => ['*'],
                            FacebookController::class => ['*'],
                            GoogleController::class => ['*'],
                        ],
                        'tasks' => [
                            CronTask::class => ['*'],
                            CacheTask::class => ['*'],
                        ],
                        'models' => [
                        
                        ],
                        'views' => [
                        
                        ],
                    ],
                    // Visitor Only
                    'visitor' => [
                    
                    ],
                    // Guest Only
                    'guest' => [
                    
                    ],
                    // User only
                    'user' => [
                    
                    ],
                    // Admin only
                    'admin' => [
                        'inherit' => [
                        
                        ],
                    ],
                    // Dev only
                    'dev' => [
                        'inherit' => [
                            'admin'
                        ],
                    ],
                ]
            ],
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
