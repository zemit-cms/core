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
use Zemit\Version;
use Zemit\Provider;
use Zemit\Utils\Env;
use Zemit\Models;
use Zemit\Modules\Admin;
use Zemit\Modules\Frontend;
use Zemit\Modules\Cli;
use Zemit\Modules\Api;
use Zemit\Mvc\Controller\Behavior;
use Phalcon\Config as PhalconConfig;

/**
 * Class Config
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Bootstrap
 *
 * @property Config $core
 * @property Config $app
 * @property Config $php
 * @property Config $debug
 * @property Config $response
 * @property Config $identity
 * @property Config $models
 * @property Config $providers
 * @property Config $logger
 * @property Config $filters
 * @property Config $modules
 * @property Config $router
 * @property Config $gravatar
 * @property Config $reCaptcha
 * @property Config $aws
 * @property Config $locale
 * @property Config $translate
 * @property Config $session
 * @property Config $module
 * @property Config $security
 * @property Config $cache
 * @property Config $metadata
 * @property Config $annotations
 * @property Config $mailer
 * @property Config $cookies
 * @property Config $oauth2
 * @property Config $dotenv
 * @property Config $client
 * @property Config $permissions
 */

class Config extends PhalconConfig
{
    public function defineConst()
    {
        defined('VENDOR_PATH') || define('VENDOR_PATH', Env::get('ROOT_PATH', 'vendor/'));
        defined('ROOT_PATH') || define('ROOT_PATH', Env::get('ROOT_PATH'));
        defined('APP_PATH') || define('APP_PATH', Env::get('APP_PATH'));
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', Env::get('APPLICATION_ENV', 'development'));
        defined('CORE_PATH') || define('CORE_PATH', Env::get('CORE_PATH', mb_substr(__DIR__, 0, mb_strlen(basename(__DIR__)) * -1)));
        defined('PRIVATE_PATH') || define('PRIVATE_PATH', Env::get('APP_PRIVATE_PATH', constant('APP_PATH') . '/private/'));
    }
    
    /**
     * Config Constructor
     * {@inheritDoc}
     *
     * @param array $data
     * @param bool $insensitive
     */
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $this->defineConst();
        
        $now = new \DateTimeImmutable();
        
        parent::__construct([
            
            /**
             * Core only settings
             */
            'core' => [
                'name' => 'Zemit Core',
                'version' => Version::get(),
                'package' => 'zemit-cms',
                'modules' => [
                    'zemit-' . \Zemit\Mvc\Module::NAME_FRONTEND => [
                        'className' => \Zemit\Modules\Frontend\Module::class,
                        'path' => CORE_PATH . 'Modules/Frontend/Module.php',
                    ],
                    'zemit-' . \Zemit\Mvc\Module::NAME_ADMIN => [
                        'className' => \Zemit\Modules\Admin\Module::class,
                        'path' => CORE_PATH . 'Modules/Admin/Module.php',
                    ],
                    'zemit-' . \Zemit\Mvc\Module::NAME_API => [
                        'className' => \Zemit\Modules\Api\Module::class,
                        'path' => CORE_PATH . 'Modules/Api/Module.php',
                    ],
                    'zemit-' . \Zemit\Mvc\Module::NAME_CLI => [
                        'className' => \Zemit\Modules\Cli\Module::class,
                        'path' => CORE_PATH . 'Modules/Cli/Module.php',
                    ],
                    'zemit-' . \Zemit\Mvc\Module::NAME_OAUTH2 => [
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
                'env' => Env::get('APP_ENV', Env::get('APPLICATION_ENV', null)), // Set the current environment
                'debug' => Env::get('APP_DEBUG', false), // Set true to display debug
                'cache' => Env::get('APP_CACHE', false), // Set true to activate the cache
                'minify' => Env::get('APP_MINIFY', false), // Set true to activate minifying
                'copyright' => Env::get('APP_COPYRIGHT', false), // Set true to activate the copyright
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
            
            'php' => [
                'ini' => [
                    'zend.exception_ignore_args' => Env::get('PHP_INI_ZEND_EXCEPTION_IGNORE_ARGS', 'On'),
                ],
            ],
            
            /**
             * Debug Configuration
             */
            'debug' => [
                'enable' => Env::get('DEBUG_ENABLE', false),
                'exception' => Env::get('DEBUG_EXCEPTION', true),
                'lowSeverity' => Env::get('DEBUG_LOW_SEVERITY', false),
                'showFiles' => Env::get('DEBUG_SHOW_FILES', true),
                'showBackTrace' => Env::get('DEBUG_SHOW_BACKTRACE', true),
                'showFileFragment' => Env::get('DEBUG_SHOW_FRAGMENT', true),
                'uri' => Env::get('DEBUG_URI'),
                'blacklist' => [
                    'server' => [
                        'PWD',
                        'PASS',
                        'PASSWD',
                        'PASSWORD',
                        'TOKEN',
                        'HASH',
                        'DB_PWD',
                        'DB_PASS',
                        'DB_PASSWD',
                        'DB_PASSWORD',
                        'DATABASE_PWD',
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
             * Response Provider Configuration
             * - Set default security headers
             */
            'response' => [
                'headers' => [
                    'Content-Security-Policy-Report-Only' => Env::get('RESPONSE_HEADER_CSP_REPORT_ONLY', "default-src 'self'; img-src 'self' data:; script-src 'self' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; object-src 'none'; connect-src 'self';"),
                    'Strict-Transport-Security' => Env::get('RESPONSE_HEADER_STRICT_TRANSPORT_SECURITY', 'max-age=63072000; includeSubDomains; preload'),
                    'X-Content-Type-Options' => Env::get('RESPONSE_HEADER_CONTENT_TYPE_OPTIONS', 'nosniff'),
                    'X-Frame-Options' => Env::get('RESPONSE_HEADER_FRAME_OPTIONS', 'Deny'),
                    'X-XSS-Protection' => Env::get('RESPONSE_HEADER_XSS_PROTECTION', 0),
                ],
                'corsHeaders' => [
                    'Access-Control-Allow-Origin' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_ORIGIN', '*'),
                    'Access-Control-Allow-Methods' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_METHODS', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'),
                    'Access-Control-Allow-Headers' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_HEADERS', 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type, Authorization'),
                    'Access-Control-Allow-Credentials' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_CREDENTIALS', 'true'),
                    'Access-Control-Max-Age' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_MAX_AGE', '600'),
//                    'Access-Control-Expose-Headers' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_EXPOSE_HEADERS', '*'),
//                    'Access-Control-Request-Headers' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_REQUEST_HEADERS', ''),
//                    'Access-Control-Request-Method' => Env::get('RESPONSE_HEADER_ACCESS_CONTROL_REQUEST_METHOD', ''),
                ],
            ],
            
            /**
             * Identity Provider Configuration
             */
            'identity' => [
                'authorizationHeader' => Env::get('IDENTITY_AUTHORIZATION_HEADER', 'Authorization'),
                'adapter' => Env::get('IDENTITY_ADAPTER', 'session'), // session | database
                'mode' => Env::get('IDENTITY_SESSION_MODE', 'jwt'), // jwt | string
                'sessionKey' => Env::get('IDENTITY_SESSION_KEY', 'zemit-identity'),
                'sessionFallback' => Env::get('IDENTITY_SESSION_FALLBACK', false),
            ],
            
            /**
             *
             */
            'models' => [
                
                // Base system
                Models\Backup::class => Models\Backup::class,
                Models\Audit::class => Models\Audit::class,
                Models\AuditDetail::class => Models\AuditDetail::class,
                Models\Log::class => Models\Log::class,
                Models\Email::class => Models\Email::class,
                Models\Job::class => Models\Job::class,
                Models\File::class => Models\File::class,
                Models\Session::class => Models\Session::class,
                Models\Flag::class => Models\Flag::class,
                Models\Setting::class => Models\Setting::class,
                
                // Translate
                Models\Lang::class => Models\Lang::class,
                Models\Translate::class => Models\Translate::class,
                Models\TranslateField::class => Models\TranslateField::class,
                Models\TranslateTable::class => Models\TranslateTable::class,
                
                // Site & CMS
                Models\Site::class => Models\Site::class,
                Models\SiteLang::class => Models\SiteLang::class,
                Models\Page::class => Models\Page::class,
                Models\Post::class => Models\Post::class,
                Models\Template::class => Models\Template::class,
                Models\Channel::class => Models\Channel::class,
                Models\Field::class => Models\Field::class,
                
                // User & Permissions
                Models\Profile::class => Models\Profile::class,
                Models\User::class => Models\User::class,
                Models\UserType::class => Models\UserType::class,
                Models\UserGroup::class => Models\UserGroup::class,
                Models\UserRole::class => Models\UserRole::class,
                Models\UserFeature::class => Models\UserFeature::class,
                
                // Role
                Models\Role::class => Models\Role::class,
                Models\RoleRole::class => Models\RoleRole::class,
                Models\RoleFeature::class => Models\RoleFeature::class,
                
                // Group
                Models\Group::class => Models\Group::class,
                Models\GroupRole::class => Models\GroupRole::class,
                Models\GroupType::class => Models\GroupType::class,
                Models\GroupFeature::class => Models\GroupFeature::class,
                
                // Type
                Models\Type::class => Models\Type::class,
                
                // Feature
                Models\Feature::class => Models\Feature::class,
            ],
            
            /**
             * Service Provider Configuration
             */
            'providers' => [
                // abstract => concrete
                Provider\Environment\ServiceProvider::class => Env::get('PROVIDER_ENVIRONMENT', Provider\Environment\ServiceProvider::class),
                Provider\Security\ServiceProvider::class => Env::get('PROVIDER_SECURITY', Provider\Security\ServiceProvider::class),
                Provider\Session\ServiceProvider::class => Env::get('PROVIDER_SESSION', Provider\Session\ServiceProvider::class),
                Provider\Cookies\ServiceProvider::class => Env::get('PROVIDER_COOKIES', Provider\Cookies\ServiceProvider::class),
                
                Provider\Locale\ServiceProvider::class => Env::get('PROVIDER_LOCALE', Provider\Locale\ServiceProvider::class),
                Provider\Translate\ServiceProvider::class => Env::get('PROVIDER_TRANSLATE', Provider\Translate\ServiceProvider::class),
                Provider\Url\ServiceProvider::class => Env::get('PROVIDER_URL', Provider\Url\ServiceProvider::class),
                Provider\Request\ServiceProvider::class => Env::get('PROVIDER_REQUEST', Provider\Request\ServiceProvider::class),
                Provider\Response\ServiceProvider::class => Env::get('PROVIDER_RESPONSE', Provider\Response\ServiceProvider::class),
                Provider\Router\ServiceProvider::class => Env::get('PROVIDER_ROUTER', Provider\Router\ServiceProvider::class),
                Provider\Dispatcher\ServiceProvider::class => Env::get('PROVIDER_DISPATCHER', Provider\Dispatcher\ServiceProvider::class),
                Provider\VoltTemplate\ServiceProvider::class => Env::get('PROVIDER_VOLT_TEMPLATE', Provider\VoltTemplate\ServiceProvider::class),
                Provider\View\ServiceProvider::class => Env::get('PROVIDER_VIEW', Provider\View\ServiceProvider::class),
                
                Provider\Profiler\ServiceProvider::class => Env::get('PROVIDER_PROFILER', Provider\Profiler\ServiceProvider::class),
                Provider\Database\ServiceProvider::class => Env::get('PROVIDER_DATABASE', Provider\Database\ServiceProvider::class),
                Provider\DatabaseReadOnly\ServiceProvider::class => Env::get('PROVIDER_DATABASE_READ_ONLY', Provider\DatabaseReadOnly\ServiceProvider::class),
                Provider\Annotations\ServiceProvider::class => Env::get('PROVIDER_ANNOTATIONS', Provider\Annotations\ServiceProvider::class),
                Provider\ModelsManager\ServiceProvider::class => Env::get('PROVIDER_MODELS_MANAGER', Provider\ModelsManager\ServiceProvider::class),
                Provider\ModelsMetadata\ServiceProvider::class => Env::get('PROVIDER_MODELS_METADATA', Provider\ModelsMetadata\ServiceProvider::class),
                Provider\ModelsCache\ServiceProvider::class => Env::get('PROVIDER_MODELS_CACHE', Provider\ModelsCache\ServiceProvider::class),
                Provider\Cache\ServiceProvider::class => Env::get('PROVIDER_CACHE', Provider\Cache\ServiceProvider::class),
                Provider\Mailer\ServiceProvider::class => Env::get('PROVIDER_MAILER', Provider\Mailer\ServiceProvider::class),
                Provider\Logger\ServiceProvider::class => Env::get('PROVIDER_LOGGER', Provider\Logger\ServiceProvider::class),
                Provider\FileSystem\ServiceProvider::class => Env::get('PROVIDER_FILE_SYSTEM', Provider\FileSystem\ServiceProvider::class),
                
                Provider\Assets\ServiceProvider::class => Env::get('PROVIDER_ASSETS', Provider\Assets\ServiceProvider::class),
                Provider\Tag\ServiceProvider::class => Env::get('PROVIDER_TAG', Provider\Tag\ServiceProvider::class),
                Provider\Filter\ServiceProvider::class => Env::get('PROVIDER_FILTER', Provider\Filter\ServiceProvider::class),
                Provider\Flash\ServiceProvider::class => Env::get('PROVIDER_FLASH', Provider\Flash\ServiceProvider::class),
                Provider\Escaper\ServiceProvider::class => Env::get('PROVIDER_ESCAPER', Provider\Escaper\ServiceProvider::class),
                Provider\Markdown\ServiceProvider::class => Env::get('PROVIDER_MARKDOWN', Provider\Markdown\ServiceProvider::class),
                Provider\Utils\ServiceProvider::class => Env::get('PROVIDER_UTILS', Provider\Utils\ServiceProvider::class),
                Provider\Crypt\ServiceProvider::class => Env::get('PROVIDER_CRYPT', Provider\Crypt\ServiceProvider::class),
                
                // oauth2
                Provider\Identity\ServiceProvider::class => Env::get('PROVIDER_IDENTITY', Provider\Identity\ServiceProvider::class),
                Provider\Oauth2Facebook\ServiceProvider::class => Env::get('PROVIDER_OAUTH_2_FACEBOOK', Provider\Oauth2Facebook\ServiceProvider::class),
                Provider\Oauth2Google\ServiceProvider::class => Env::get('PROVIDER_OAUTH_2_GOOGLE', Provider\Oauth2Google\ServiceProvider::class),
                
                // lib
                Provider\Aws\ServiceProvider::class => Env::get('PROVIDER_AWS', Provider\Aws\ServiceProvider::class),
                Provider\OCR\ServiceProvider::class => Env::get('PROVIDER_OCR', Provider\OCR\ServiceProvider::class),
                Provider\Jwt\ServiceProvider::class => Env::get('PROVIDER_JWT', Provider\Jwt\ServiceProvider::class),
                Provider\V8js\ServiceProvider::class => Env::get('PROVIDER_V8_JS', Provider\V8js\ServiceProvider::class),
                Provider\Captcha\ServiceProvider::class => Env::get('PROVIDER_CAPTCHA', Provider\Captcha\ServiceProvider::class),
                Provider\Gravatar\ServiceProvider::class => Env::get('PROVIDER_GRAVATAR', Provider\Gravatar\ServiceProvider::class),
                Provider\Clamav\ServiceProvider::class => Env::get('PROVIDER_CLAMAV', Provider\Clamav\ServiceProvider::class),
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
                \Zemit\Mvc\Module::NAME_ADMIN => [
                    'className' => \Zemit\Modules\Admin\Module::class,
                    'path' => CORE_PATH . 'Modules/Admin/Module.php',
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
//                \Zemit\Modules\Admin\Module::class => \Zemit\Modules\Admin\Module::class,
//                \Zemit\Modules\Api\Module::class => \Zemit\Modules\Api\Module::class,
//                \Zemit\Modules\Cli\Module::class => \Zemit\Modules\Cli\Module::class,
            ],
            
            /**
             * Default router settings
             */
            'router' => [
                'hostnames' => [],
                'defaults' => [
                    'namespace' => Env::get('ROUTER_DEFAULT_NAMESPACE', 'Zemit\\Modules\\Frontend\\Controllers'),
                    'module' => Env::get('ROUTER_DEFAULT_MODULE', 'frontend'),
                    'controller' => Env::get('ROUTER_DEFAULT_CONTROLLER', 'index'),
                    'action' => Env::get('ROUTER_DEFAULT_ACTION', 'index'),
                ],
                'cli' => [
                    'namespace' => Env::get('ROUTER_DEFAULT_NAMESPACE', 'Zemit\\Modules\\Cli\\Tasks'),
                    'module' => Env::get('ROUTER_DEFAULT_MODULE', 'cli'),
                    'task' => Env::get('ROUTER_DEFAULT_TASK', 'help'),
                    'action' => Env::get('ROUTER_DEFAULT_ACTION', 'main'),
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
                        'adapter' => Env::get('SESSION_STREAM_ADAPTER', \Phalcon\Session\Adapter\Stream::class),
                        'savePath' => Env::get('SESSION_STREAM_SAVE_PATH', '/tmp'),
                    ],
                    'memcached' => [
                        'adapter' => Env::get('SESSION_MEMCACHED_ADAPTER', \Phalcon\Session\Adapter\Libmemcached::class),
                        'servers' => [
                            [
                                'host' => Env::get('SESSION_MEMCACHED_HOST', Env::get('MEMCACHED_HOST', '127.0.0.1')),
                                'port' => Env::get('SESSION_MEMCACHED_PORT', Env::get('MEMCACHED_PORT', 11211)),
                                'weight' => Env::get('SESSION_MEMCACHED_WEIGHT', Env::get('MEMCACHED_WEIGHT', 100)),
                            ],
                        ],
                        'client' => [],
                    ],
                    'redis' => [
                        'adapter' => Env::get('SESSION_REDIS_ADAPTER', \Phalcon\Session\Adapter\Redis::class),
                        'defaultSerializer' => Env::get('SESSION_REDIS_DEFAULT_SERIALIZER', Env::get('REDIS_DEFAULT_SERIALIZER', 'php')),
                        'lifetime' => Env::get('SESSION_REDIS_LIFETIME', Env::get('REDIS_LIFETIME', 3600)),
                        'serializer' => Env::get('SESSION_REDIS_SERIALIZER', Env::get('REDIS_SERIALIZER', null)),
                        'host' => Env::get('SESSION_REDIS_HOST', Env::get('REDIS_HOST', '127.0.0.1')),
                        'port' => Env::get('SESSION_REDIS_PORT', Env::get('REDIS_PORT', 6379)),
                        'index' => Env::get('SESSION_REDIS_INDEX', Env::get('REDIS_INDEX', 1)),
                        'auth' => Env::get('SESSION_REDIS_AUTH', Env::get('REDIS_AUTH', null)),
                        'persistent' => Env::get('SESSION_REDIS_PERSISTENT', Env::get('REDIS_PERSISTENT', 0)),
                        'socket' => Env::get('SESSION_REDIS_SOCKET', Env::get('REDIS_SOCKET', null)),
                    ],
                    'noop' => [
                        'adapter' => Env::get('SESSION_NOOP_ADAPTER', \Phalcon\Session\Adapter\Noop::class),
                    ],
                ],
                'default' => [
                    'prefix' => Env::get('SESSION_PREFIX', 'zemit_session_'),
                    'uniqueId' => Env::get('SESSION_UNIQUE_ID', 'zemit_'),
                    'lifetime' => Env::get('SESSION_LIFETIME', 3600),
                ],
                'ini' => [
                    'session.save_path' => Env::get('SESSION_SAVE_PATH', ''),
                    'session.name' => Env::get('SESSION_NAME', 'PHPSESSID'),
                    'session.save_handler' => Env::get('SESSION_SAVE_HANDLER', 'files'),
                    'session.auto_start' => Env::get('SESSION_AUTO_START', '0'),
                    'session.gc_probability' => Env::get('SESSION_GC_PROBABILITY', '1'),
                    'session.gc_divisor' => Env::get('SESSION_GC_DIVISOR', '100'),
                    'session.gc_maxlifetime' => Env::get('SESSION_GC_MAXLIFETIME', '1440'),
                    'session.serialize_handler' => Env::get('SESSION_SERIALIZE_HANDLER', 'php'),
                    'session.cookie_lifetime' => Env::get('SESSION_COOKIE_LIFETIME', '0'),
                    'session.cookie_path' => Env::get('SESSION_COOKIE_PATH', '/'),
                    'session.cookie_domain' => Env::get('SESSION_COOKIE_DOMAIN', ''),
                    'session.cookie_secure' => Env::get('SESSION_COOKIE_SECURE', '1'),
                    'session.cookie_httponly' => Env::get('SESSION_COOKIE_HTTPONLY', '1'),
                    'session.cookie_samesite' => Env::get('SESSION_COOKIE_SAMESITE', ''),
                    'session.use_strict_mode' => Env::get('SESSION_USE_STRICT_MODE', '0'),
                    'session.use_cookies' => Env::get('SESSION_USE_COOKIES', '1'),
                    'session.use_only_cookies' => Env::get('SESSION_USE_ONLY_COOKIES', '1'),
                    'session.referer_check' => Env::get('SESSION_REFERER_CHECK', ''),
                    'session.cache_limiter' => Env::get('SESSION_CACHE_LIMITER', 'nocache'),
                    'session.cache_expire' => Env::get('SESSION_CACHE_EXPIRE', '180'),
                    'session.use_trans_sid' => Env::get('SESSION_USE_TRANS_SID', '0'),
                    'session.trans_sid_tags' => Env::get('SESSION_TRANS_SID_TAGS', 'a=href,area=href,frame=src,form='),
                    'session.trans_sid_hosts' => Env::get('SESSION_TRANS_SID_HOSTS', $_SERVER['HTTP_HOST'] ?? ''),
                    'session.sid_length' => Env::get('SESSION_SID_LENGTH', '32'),
                    'session.sid_bits_per_character' => Env::get('SESSION_SID_BITS_PER_CHARACTER', '4'),
                    'session.upload_progress.enabled' => Env::get('SESSION_UPLOAD_PROGRESS_ENABLED', '1'),
                    'session.upload_progress.cleanup' => Env::get('SESSION_UPLOAD_PROGRESS_CLEANUP', '1'),
                    'session.upload_progress.prefix' => Env::get('SESSION_UPLOAD_PROGRESS_PREFIX', 'upload_progress_'),
                    'session.upload_progress.name' => Env::get('SESSION_UPLOAD_PROGRESS_NAME', 'PHP_SESSION_UPLOAD_PROGRESS'),
                    'session.upload_progress.freq' => Env::get('SESSION_UPLOAD_PROGRESS_FREQ', '1%'),
                    'session.upload_progress.min_freq' => Env::get('SESSION_UPLOAD_PROGRESS_MIN_FREQ', '1'),
                    'session.lazy_write' => Env::get('SESSION_LAZY_WRITE', '1'),
                    'session.hash_function' => Env::get('SESSION_HASH_FUNCTION', '0'),
                    'session.hash_bits_per_character' => Env::get('SESSION_HASH_BITS_PER_CHARACTER', '4'),
                    'session.entropy_file' => Env::get('SESSION_ENTROPY_FILE', ''),
                    'session.entropy_length' => Env::get('SESSION_ENTROPY_LENGTH', '0'),
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
                'salt' => Env::get('SECURITY_SALT', '>mY.Db5fR?k%~<ZWf\}Zh35_IFC]#0Xx'), // salt for the phalcon security service
                'jwt' => [
                    'signer' => Env::get('SECURITY_JWT_SIGNER', \Phalcon\Security\JWT\Signer\Hmac::class),
                    'algo' => Env::get('SECURITY_JWT_ALGO', 'sha512'),
                    'contentType' => Env::get('SECURITY_JWT_CONTENT_TYPE', 'application/json'),
                    'expiration' => $now->modify(Env::get('SECURITY_JWT_EXPIRATION', '+1 day'))->getTimestamp(),
                    'notBefore' => $now->modify(Env::get('SECURITY_JWT_NOT_BEFORE', '-1 minute'))->getTimestamp(),
                    'issuedAt' => $now->modify(Env::get('SECURITY_JWT_ISSUED_AT', 'now'))->getTimestamp(),
                    'issuer' => Env::get('SECURITY_JWT_ISSUER', 'ZEMIT_CORE_DEFAULT_ISSUER'),
                    'audience' => Env::get('SECURITY_JWT_AUDIENCE', 'ZEMIT_CORE_DEFAULT_AUDIENCE'),
                    'id' => Env::get('SECURITY_JWT_ID', 'ZEMIT_CORE_DEFAULT_ID'),
                    'subject' => Env::get('SECURITY_JWT_SUBJECT', 'ZEMIT_CORE_DEFAULT_SUBJECT'),
                    'passphrase' => Env::get('SECURITY_JWT_PASSPHRASE', 'Tf0PHY/^yDdJs*~)?x#xCNj_N[jW/`c*'),
                ],
            ],
            
            /**
             * Cache drivers configs
             */
            'cache' => [
                'cli' => Env::get('CACHE_DRIVER_CLI', 'memory'),
                'driver' => Env::get('CACHE_DRIVER', 'memory'),
                'drivers' => [
                    'memory' => [
                        'adapter' => Env::get('CACHE_MEMORY_ADAPTER', \Phalcon\Cache\Adapter\Memory::class),
                    ],
                    'apcu' => [
                        'adapter' => Env::get('CACHE_APCU_ADAPTER', \Phalcon\Cache\Adapter\Apcu::class),
                    ],
                    'stream' => [
                        'adapter' => Env::get('CACHE_STREAM_ADAPTER', \Phalcon\Cache\Adapter\Stream::class),
                        'cacheDir' => Env::get('CACHE_STREAM_DIR', PRIVATE_PATH . '/cache/data/'),
                    ],
                    'memcached' => [
                        'adapter' => Env::get('CACHE_MEMCACHED_ADAPTER', \Phalcon\Cache\Adapter\Libmemcached::class),
                        'servers' => [
                            [
                                'host' => Env::get('CACHE_MEMCACHED_HOST', Env::get('MEMCACHED_HOST', '127.0.0.1')),
                                'port' => Env::get('CACHE_MEMCACHED_PORT', Env::get('MEMCACHED_PORT', 11211)),
                                'weight' => Env::get('CACHE_MEMCACHED_WEIGHT', Env::get('MEMCACHED_WEIGHT', 100)),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => Env::get('CACHE_REDIS_ADAPTER', \Phalcon\Cache\Adapter\Redis::class),
                        'defaultSerializer' => Env::get('CACHE_REDIS_DEFAULT_SERIALIZER', Env::get('REDIS_DEFAULT_SERIALIZER', 'php')),
                        'lifetime' => Env::get('CACHE_REDIS_LIFETIME', Env::get('REDIS_LIFETIME', 3600)),
                        'serializer' => Env::get('CACHE_REDIS_SERIALIZER', Env::get('REDIS_SERIALIZER', null)),
                        'host' => Env::get('CACHE_REDIS_HOST', Env::get('REDIS_HOST', '127.0.0.1')),
                        'port' => Env::get('CACHE_REDIS_PORT', Env::get('REDIS_PORT', 6379)),
                        'index' => Env::get('CACHE_REDIS_INDEX', Env::get('REDIS_INDEX', 1)),
                        'auth' => Env::get('CACHE_REDIS_AUTH', Env::get('REDIS_AUTH', null)),
                        'persistent' => Env::get('CACHE_REDIS_PERSISTENT', Env::get('REDIS_PERSISTENT', null)),
                        'socket' => Env::get('CACHE_REDIS_SOCKET', Env::get('REDIS_SOCKET', null)),
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
                'cli' => Env::get('METADATA_DRIVER_CLI', 'memory'),
                'driver' => Env::get('METADATA_DRIVER', 'memory'),
                'drivers' => [
                    'apcu' => [
                        'adapter' => Env::get('METADATA_APCU_ADAPTER', \Phalcon\Mvc\Model\MetaData\Apcu::class),
                    ],
                    'memory' => [
                        'adapter' => Env::get('METADATA_MEMORY_ADAPTER', \Phalcon\Mvc\Model\MetaData\Memory::class),
                    ],
                    'stream' => [
                        'adapter' => Env::get('METADATA_STREAM_ADAPTER', \Phalcon\Mvc\Model\MetaData\Stream::class),
                        'metaDataDir' => Env::get('METADATA_STREAM_DIR', PRIVATE_PATH . '/cache/metadata/'),
                    ],
                    'memcached' => [
                        'adapter' => Env::get('METADATA_MEMCACHED_ADAPTER', \Phalcon\Mvc\Model\MetaData\Libmemcached::class),
                        'servers' => [
                            [
                                'host' => Env::get('METADATA_MEMCACHED_HOST', Env::get('MEMCACHED_HOST', '127.0.0.1')),
                                'port' => Env::get('METADATA_MEMCACHED_PORT', Env::get('MEMCACHED_PORT', 11211)),
                                'weight' => Env::get('METADATA_MEMCACHED_WEIGHT', Env::get('MEMCACHED_WEIGHT', 100)),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => Env::get('METADATA_REDIS_ADAPTER', \Phalcon\Mvc\Model\MetaData\Redis::class),
                        'defaultSerializer' => Env::get('METADATA_REDIS_DEFAULT_SERIALIZER', Env::get('REDIS_DEFAULT_SERIALIZER', 'php')),
                        'lifetime' => Env::get('METADATA_REDIS_LIFETIME', Env::get('REDIS_LIFETIME', 3600)),
                        'serializer' => Env::get('METADATA_REDIS_SERIALIZER', Env::get('REDIS_SERIALIZER', null)),
                        'host' => Env::get('METADATA_REDIS_HOST', Env::get('REDIS_HOST', '127.0.0.1')),
                        'port' => Env::get('METADATA_REDIS_PORT', Env::get('REDIS_PORT', 6379)),
                        'index' => Env::get('METADATA_REDIS_INDEX', Env::get('REDIS_INDEX', 1)),
                        'auth' => Env::get('METADATA_REDIS_AUTH', Env::get('REDIS_AUTH', null)),
                        'persistent' => Env::get('METADATA_REDIS_PERSISTENT', Env::get('REDIS_PERSISTENT', null)),
                        'socket' => Env::get('METADATA_REDIS_SOCKET', Env::get('REDIS_SOCKET', null)),
                    ],
                    'wincache' => [
                        'adapter' => Env::get('METADATA_WINCACHE_ADAPTER', \Phalcon\Mvc\Model\MetaData\Wincache::class),
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
                        'adapter' => Env::get('ANNOTATIONS_MEMORY_ADAPTER', \Phalcon\Annotations\Adapter\Memory::class),
                    ],
                    'apcu' => [
                        'adapter' => Env::get('ANNOTATIONS_APCU_ADAPTER', \Phalcon\Annotations\Adapter\Apcu::class),
                    ],
                    'file' => [
                        'adapter' => Env::get('ANNOTATIONS_STREAM_ADAPTER', \Phalcon\Annotations\Adapter\Stream::class),
                        'annotationsDir' => Env::get('ANNOTATIONS_STREAM_DIR', PRIVATE_PATH . '/cache/annotations'),
                    ],
                    'memcached' => [
                        'adapter' => Env::get('ANNOTATIONS_MEMCACHED_ADAPTER', \Phalcon\Annotations\Adapter\Memcached::class),
                        'servers' => [
                            [
                                'host' => Env::get('ANNOTATIONS_MEMCACHED_HOST', Env::get('MEMCACHED_HOST', '127.0.0.1')),
                                'port' => Env::get('ANNOTATIONS_MEMCACHED_PORT', Env::get('MEMCACHED_PORT', 11211)),
                                'weight' => Env::get('ANNOTATIONS_MEMCACHED_WEIGHT', Env::get('MEMCACHED_WEIGHT', 100)),
                            ],
                        ],
                    ],
                    'redis' => [
                        'adapter' => Env::get('ANNOTATIONS_REDIS_ADAPTER', \Phalcon\Annotations\Adapter\Redis::class),
                        'defaultSerializer' => Env::get('ANNOTATIONS_REDIS_DEFAULT_SERIALIZER', Env::get('REDIS_DEFAULT_SERIALIZER', 'php')),
                        'lifetime' => Env::get('ANNOTATIONS_REDIS_LIFETIME', Env::get('REDIS_LIFETIME', 3600)),
                        'serializer' => Env::get('ANNOTATIONS_REDIS_SERIALIZER', Env::get('REDIS_SERIALIZER', null)),
                        'host' => Env::get('ANNOTATIONS_REDIS_HOST', Env::get('REDIS_HOST', '127.0.0.1')),
                        'port' => Env::get('ANNOTATIONS_REDIS_PORT', Env::get('REDIS_PORT', 6379)),
                        'index' => Env::get('ANNOTATIONS_REDIS_INDEX', Env::get('REDIS_INDEX', 1)),
                        'auth' => Env::get('ANNOTATIONS_REDIS_AUTH', Env::get('REDIS_AUTH', null)),
                        'persistent' => Env::get('ANNOTATIONS_REDIS_PERSISTENT', Env::get('REDIS_PERSISTENT', null)),
                        'socket' => Env::get('ANNOTATIONS_REDIS_SOCKET', Env::get('REDIS_SOCKET', null)),
                    ],
                    'aerospike' => [
                        'adapter' => Env::get('ANNOTATIONS_AEROSPIKE_ADAPTER', \Phalcon\Annotations\Adapter\Aerospike::class),
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
                        'dialectClass' => Env::get('DATABASE_DIALECT_CLASS', \Zemit\Db\Dialect\Mysql::class),
                        'host' => Env::get('DATABASE_HOST', 'localhost'),
                        'port' => Env::get('DATABASE_PORT', 3306),
                        'dbname' => Env::get('DATABASE_DBNAME', ''),
                        'username' => Env::get('DATABASE_USERNAME', 'root'),
                        'password' => Env::get('DATABASE_PASSWORD', ''),
                        'charset' => Env::get('DATABASE_CHARSET', 'utf8'),
                        'options' => [
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . Env::get('DATABASE_CHARSET', 'utf8'),
                            PDO::ATTR_EMULATE_PREPARES => Env::get('DATABASE_PDO_EMULATE_PREPARES', false), // https://stackoverflow.com/questions/10113562/pdo-mysql-use-pdoattr-emulate-prepares-or-not
                            PDO::ATTR_STRINGIFY_FETCHES => Env::get('DATABASE_PDO_STRINGIFY_FETCHES', false),
                            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => Env::get('MYSQL_ATTR_SSL_VERIFY_SERVER_CERT', true),
                        ],
                        /**
                         * ReadOnly Configuration
                         */
                        'readOnly' => [
                            'enable' => Env::get('DATABASE_READONLY_ENABLE', false),
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
             * AWS - Amazon Web Service
             */
            'aws' => [
                'region' => Env::get('AWS_REGION', 'ca-central-1'),
                'version' => Env::get('AWS_VERSION', 'latest'),
                'credentials' => [
                    'key' => Env::get('AWS_CREDENTIALS_KEY', ''),
                    'secret' => Env::get('AWS_CREDENTIALS_SECRET', ''),
                ],
            ],
            
            /**
             * Oauth2
             */
            'oauth2' => [
                'client' => [
                    'clientId' => Env::get('OAUTH2_CLIENT_ID'),
                    'clientSecret' => Env::get('OAUTH2_CLIENT_SECRET'),
                    'redirectUri' => Env::get('OAUTH2_CLIENT_REDIRECT_URI', '/oauth2/client/redirect'),
                    'urlAuthorize' => Env::get('OAUTH2_CLIENT_URL_AUTHORIZE', '/oauth2/client/authorize'),
                    'urlAccessToken' => Env::get('OAUTH2_CLIENT_URL_ACCESS_TOKEN', '/oauth2/client/token'),
                    'urlResourceOwnerDetails' => Env::get('OAUTH2_CLIENT_URL_RESOURCE', '/oauth2/client/resource'),
                    'proxy' => Env::get('OAUTH2_CLIENT_PROXY', null),
                    'verify' => Env::get('OAUTH2_CLIENT_VERIFY', true),
                ],
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
    
            'openai' => [
                'secretKey' => Env::get('OPENAI_SECRET_KEY'),
            ],
    
            /**
             * Imap
             * https://packagist.org/packages/php-imap/php-imap
             */
            'imap' => [
                'path' => Env::get('IMAP_PATH'), // IMAP server and mailbox folder
                'login' => Env::get('IMAP_LOGIN'), // Username for the before configured mailbox
                'password' => Env::get('IMAP_PASSWORD'), // Password for the before configured username
                'attachmentsDir' => Env::get('IMAP_ATTACHMENTS_DIR'), // Server encoding (optional)
                'serverEncoding' => Env::get('IMAP_SERVER_ENCODING', 'UTF-8'), // Directory, where attachments will be saved (optional)
                'trimImapPath' => Env::get('IMAP_TRIM_IMAP_PATH', true),   // Trim leading/ending whitespaces of IMAP path (optional)
                'attachmentFilenameMode' => Env::get('IMAP_ATTACHMENT_FILENAME_MODE', false), // Attachment filename mode (optional; false = random filename; true = original filename)
            ],
            
            /**
             * Dotenv
             */
            'dotenv' => [
                'filePath' => '',
            ],
            
            /**
             * Client config to pass to front-end
             */
            'client' => [],
            
            /**
             * Application permissions
             */
            'permissions' => [
                
                /**
                 * Feature permissions
                 */
                'features' => [
                    
                    'test' => [
                        'components' => [
                            Api\Controllers\TestController::class => ['*'],
                        ],
                    ],
                    
                    'base' => [
                        'components' => [
                            Api\Controllers\AuthController::class => ['get'],
                            Models\Audit::class => ['create'],
                            Models\AuditDetail::class => ['create'],
                            Models\Session::class => ['*'],
                        ],
                    ],
                    
                    'login' => [
                        'components' => [
                            Api\Controllers\AuthController::class => ['login'],
                            Models\User::class => ['find'],
                        ],
                    ],
                    
                    'logout' => [
                        'components' => [
                            Api\Controllers\AuthController::class => ['logout'],
                        ],
                    ],
                    
                    'register' => [
                        'components' => [
                            Api\Controllers\AuthController::class => ['register'],
                            Models\User::class => ['find', 'create'],
                        ],
                    ],
                    
                    'cron' => [
                        'components' => [
                            Cli\Tasks\CronTask::class => ['*'],
                        ],
                    ],
                    
                    'manageRoleList' => [
                        'components' => [
                            Api\Controllers\RoleController::class => ['*'],
                            Models\Role::class => ['*'],
                            Models\UserRole::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\RoleController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageGroupList' => [
                        'components' => [
                            Api\Controllers\GroupController::class => ['*'],
                            Models\Group::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\GroupController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageTypeList' => [
                        'components' => [
                            Api\Controllers\TypeController::class => ['*'],
                            Models\Group::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\TypeController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageLangList' => [
                        'components' => [
                            Api\Controllers\LangController::class => ['*'],
                            Models\Lang::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\LangController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageUserList' => [
                        'components' => [
                            Api\Controllers\UserController::class => ['*'],
                            Models\User::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\UserController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageTemplateList' => [
                        'components' => [
                            Api\Controllers\TemplateController::class => ['*'],
                            Models\Template::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\TemplateController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'manageAuditList' => [
                        'components' => [
                            Api\Controllers\AuditController::class => ['*'],
                            Models\Audit::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\AuditController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
    
                    'manageSiteList' => [
                        'components' => [
                            Api\Controllers\SiteController::class => ['*'],
                            Models\Site::class => ['*'],
                            Models\SiteLang::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\SiteController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
    
                    'managePageList' => [
                        'components' => [
                            Api\Controllers\PageController::class => ['*'],
                            Models\Page::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\PageController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    
                    'managePostList' => [
                        'components' => [
                            Api\Controllers\PostController::class => ['*'],
                            Models\Post::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\PostController::class => [
                                Behavior\Skip\SkipIdentityCondition::class,
                                Behavior\Skip\SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                ],
                
                /**
                 * Roles permissions
                 */
                'roles' => [
                    
                    // Console (CLI)
                    'cli' => [
                        'components' => [
                            Cli\Tasks\BuildTask::class => ['*'],
                            Cli\Tasks\CacheTask::class => ['*'],
                            Cli\Tasks\CronTask::class => ['*'],
                            Cli\Tasks\ErrorTask::class => ['*'],
                            Cli\Tasks\DeploymentTask::class => ['*'],
                            Cli\Tasks\HelpTask::class => ['*'],
                            Cli\Tasks\ScaffoldTask::class => ['*'],
                            Cli\Tasks\TestTask::class => ['*'],
                        ],
                    ],
                    
                    // Everyone with or without role
                    'everyone' => [
                        'features' => [
                            'base',
                        ],
                    ],
                    
                    // Everyone without role
                    'guest' => [
                        'features' => [
                            'login',
                            'logout',
                            'register',
                        ],
                    ],
                    
                    // User
                    'user' => [
                        'features' => [
                            'logout',
                        ],
                    ],
                    
                    // Admin
                    'admin' => [
                        'features' => [
                            'manageUserList',
                            'manageLangList',
                            'manageSiteList',
                            'managePageList',
                            'managePostList',
                            'manageTemplateList',
                        ],
                        'inherit' => [
                            'user',
                        ],
                        'behaviors' => [
                        ],
                    ],
                    
                    // Dev
                    'dev' => [
                        'features' => [
                            'manageRoleList',
                            'manageGroupList',
                            'manageTypeList',
                            'manageAuditList',
                        ],
                        'inherit' => [
                            'user',
                            'admin',
                        ],
                    ],
                ],
            ],
        ], $insensitive);
        if (!empty($data)) {
            $this->merge(new PhalconConfig($data, $insensitive));
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
    public function mergeEnvConfig(?string $env = null) : self
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
    
    /**
     * Return the mapped model class name from $this->models->$class
     *
     * @param string $class
     * @return string
     */
    public function getModelClass(string $class) : string
    {
        return $this->path('models.' . $class) ?: $class;
    }
}

//if (php_sapi_name() === 'cli') {
//    $devtoolConfig = new Config();
//    return $devtoolConfig->mergeEnvConfig();
//}
