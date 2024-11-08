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
use Phalcon\Config\Config as PhalconConfig;
use Phalcon\Db\Column;
use Phalcon\Encryption\Security;
use Phalcon\Support\Version as PhalconVersion;
use Zemit\Bootstrap\Permissions\TableConfig;
use Zemit\Bootstrap\Permissions\WorkspaceConfig;
use Zemit\Locale;
use Zemit\Models;
use Zemit\Modules\Frontend;
use Zemit\Modules\Api;
use Zemit\Modules\Cli;
use Zemit\Mvc\Controller\Behavior;
use Zemit\Provider;
use Zemit\Support\Env;
use Zemit\Support\Version;

/**
 * Global Zemit Configuration
 *
 * @property PhalconConfig $phalcon
 * @property PhalconConfig $core
 * @property PhalconConfig $app
 * @property PhalconConfig $php
 * @property PhalconConfig $debug
 * @property PhalconConfig $response
 * @property PhalconConfig $identity
 * @property PhalconConfig $models
 * @property PhalconConfig $providers
 * @property PhalconConfig $logger
 * @property PhalconConfig $filters
 * @property PhalconConfig $modules
 * @property PhalconConfig $router
 * @property PhalconConfig $gravatar
 * @property PhalconConfig $reCaptcha
 * @property PhalconConfig $aws
 * @property PhalconConfig $locale
 * @property PhalconConfig $translate
 * @property PhalconConfig $session
 * @property PhalconConfig $module
 * @property PhalconConfig $security
 * @property PhalconConfig $cache
 * @property PhalconConfig $metadata
 * @property PhalconConfig $annotations
 * @property PhalconConfig $mailer
 * @property PhalconConfig $cookies
 * @property PhalconConfig $oauth2
 * @property PhalconConfig $dotenv
 * @property PhalconConfig $client
 * @property PhalconConfig $permissions
 */
class Config extends \Zemit\Config\Config
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
     */
    public function __construct(array $data = [], bool $insensitive = false)
    {
        $this->defineConst();
        $now = new \DateTimeImmutable();
        $data = $this->internalMergeAppend([
            
            /**
             * Phalcon settings
             */
            'phalcon' => [
                'name' => 'Phalcon Framework',
                'version' => (new PhalconVersion())->get(),
            ],
            
            /**
             * Core settings
             */
            'core' => [
                'name' => 'Zemit Core',
                'version' => (new Version())->get(),
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
                    'zemit-' . \Zemit\Mvc\Module::NAME_OAUTH2 => [
                        'className' => \Zemit\Modules\Oauth2\Module::class,
                        'path' => CORE_PATH . 'Modules/Oauth2/Module.php',
                    ],
                    'zemit-' . \Zemit\Cli\Module::NAME_CLI => [
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
                'name' => Env::get('APP_NAME', 'Zemit'), // Name of your application
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
            
            'url' => [
                'staticBaseUri' => Env::get('URL_STATIC_BASE_URI', null),
                'baseUri' => Env::get('URL_BASE_URI', '/'),
                'basePath' => Env::get('URL_BASE_PATH', '/'),
            ],
            
            'php' => [
                'locale' => [
                    'category' => Env::get('PHP_LOCALE_CATEGORY', LC_ALL),
                    'rest' => explode(',', Env::get('PHP_LOCALE_REST', 'fr_CA.UTF-8,French_Canada.1252')),
                ],
                'date' => [
                    'timezone' => Env::get('PHP_DATE_TIMEZONE', 'America/Montreal'),
                ],
                'ini' => [
                    'zend.exception_ignore_args' => Env::get('PHP_INI_ZEND_EXCEPTION_IGNORE_ARGS', 'On'),
                ],
            ],
            
            /**
             * Debug Configuration
             */
            'debug' => [
                'enable' => Env::get('DEBUG_ENABLE', false),
                'exceptions' => Env::get('DEBUG_EXCEPTIONS', true),
                'lowSeverity' => Env::get('DEBUG_LOW_SEVERITY', false),
                'showFiles' => Env::get('DEBUG_SHOW_FILES', false),
                'showBackTrace' => Env::get('DEBUG_SHOW_BACKTRACE', false),
                'showFileFragment' => Env::get('DEBUG_SHOW_FILE_FRAGMENT', false),
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
                        'DATABASE_USERNAME',
                        'DATABASE_PWD',
                        'DATABASE_PASS',
                        'DATABASE_PASSWD',
                        'DATABASE_PASSWORD',
                        'SECURITY_WORK_FACTOR',
                        'SECURITY_SALT',
                        'PASSPHRASE',
                        'SECRET',
                        'API_SECRET',
                        'API_KEY',
                        'MAILER_SMTP_HOST',
                        'MAILER_SMTP_PORT',
                        'MAILER_SMTP_PASSWORD',
                        'MAILER_SMTP_USERNAME',
                        'MAILER_FROM_EMAIL',
                        'MAILER_FROM_NAME',
                        'COOKIES_SIGN_KEY',
                        'SECURITY_JWT_PASSPHRASE',
                        'RECAPTCHA_KEY',
                        'RECAPTCHA_SECRET',
                        'AWS_CREDENTIALS_KEY',
                        'AWS_CREDENTIALS_SECRET',
                        'OAUTH2_CLIENT_ID',
                        'OAUTH2_CLIENT_SECRET',
                        'OAUTH2_FACEBOOK_CLIENT_ID',
                        'OAUTH2_FACEBOOK_CLIENT_SECRET',
                        'OAUTH2_GOOGLE_CLIENT_ID',
                        'OAUTH2_GOOGLE_CLIENT_SECRET',
                        'OPENAI_SECRET_KEY',
                        'OPENAI_ORGANIZATION_ID',
                        'IMAP_LOGIN',
                        'IMAP_PASSWORD',
                    ],
                ],
            ],
            
            /**
             * Response Provider Configuration
             * - Set default security headers
             */
            'response' => [
                'headers' => [
                    'Content-Security-Policy-Report-Only' => Env::get('RESPONSE_HEADER_CSP_REPORT_ONLY', ''),
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
                'token' => [
                    'expiration' => $now->modify(Env::get('IDENTITY_TOKEN_EXPIRATION', '+1 day'))->getTimestamp(),
                ],
                'refreshToken' => [
                    'expiration' => $now->modify(Env::get('IDENTITY_REFRESH_TOKEN_EXPIRATION', '+7 day'))->getTimestamp(),
                ],
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
                Models\Workspace::class => Models\Workspace::class,
                Models\WorkspaceLang::class => Models\WorkspaceLang::class,
                Models\Page::class => Models\Page::class,
                Models\Post::class => Models\Post::class,
                Models\Template::class => Models\Template::class,
                Models\Table::class => Models\Table::class,
                Models\Field::class => Models\Field::class,
                
                // User & Permissions
                Models\Oauth2::class => Models\Oauth2::class,
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
            
            'dataLifeCycle' => [
                'models' => [
                    Models\Log::class => Env::get('DATA_LIFE_CYCLE_LOG', 'triennially'),
                    Models\Email::class => Env::get('DATA_LIFE_CYCLE_EMAIL', 'triennially'),
                    Models\Session::class => Env::get('DATA_LIFE_CYCLE_SESSION', 'monthly'),
                    Models\Audit::class => Env::get('DATA_LIFE_CYCLE_AUDIT', 'quarterly'),
                    Models\AuditDetail::class => Env::get('DATA_LIFE_CYCLE_AUDIT_DETAIL', 'quarterly'),
                ],
                'policies' => [
                    'monthly' => [
                        'query' => [
                            'conditions' => 'createdAt < :createdAt:',
                            'bind' => ['createdAt' => $now->modify('-1 month')->format('Y-m-01 00:00:00')],
                            'bindTypes' => ['createdAt' => Column::BIND_PARAM_STR],
                        ],
                    ],
                    'quarterly' => [
                        'query' => [
                            'conditions' => 'createdAt < :createdAt:',
                            'bind' => ['createdAt' => $now->modify('-3 months')->format('Y-m-01 00:00:00')],
                            'bindTypes' => ['createdAt' => Column::BIND_PARAM_STR],
                        ],
                    ],
                    'yearly' => [
                        'query' => [
                            'conditions' => 'createdAt < :createdAt:',
                            'bind' => ['createdAt' => $now->modify('-1 year')->format('Y-01-01 00:00:00')],
                            'bindTypes' => ['createdAt' => Column::BIND_PARAM_STR],
                        ],
                    ],
                    'biennially' => [
                        'query' => [
                            'conditions' => 'createdAt < :createdAt:',
                            'bind' => ['createdAt' => $now->modify('-2 year')->format('Y-01-01 00:00:00')],
                            'bindTypes' => ['createdAt' => Column::BIND_PARAM_STR],
                        ],
                    ],
                    'triennially' => [
                        'query' => [
                            'conditions' => 'createdAt < :createdAt:',
                            'bind' => ['createdAt' => $now->modify('-3 year')->format('Y-01-01 00:00:00')],
                            'bindTypes' => ['createdAt' => Column::BIND_PARAM_STR],
                        ],
                    ],
                ],
            ],
            
            /**
             * Service Provider Configuration
             * expected => actual
             */
            'providers' => [
                // Application
                Provider\Application\ServiceProvider::class => Env::get('PROVIDER_APPLICATION', Provider\Application\ServiceProvider::class),
                Provider\Console\ServiceProvider::class => Env::get('PROVIDER_CONSOLE', Provider\Console\ServiceProvider::class),
                Provider\Debug\ServiceProvider::class => Env::get('PROVIDER_CONSOLE', Provider\Debug\ServiceProvider::class),
                Provider\Env\ServiceProvider::class => Env::get('PROVIDER_ENVIRONMENT', Provider\Env\ServiceProvider::class),
                Provider\Router\ServiceProvider::class => Env::get('PROVIDER_ROUTER', Provider\Router\ServiceProvider::class),
                Provider\Dispatcher\ServiceProvider::class => Env::get('PROVIDER_DISPATCHER', Provider\Dispatcher\ServiceProvider::class),
                Provider\Request\ServiceProvider::class => Env::get('PROVIDER_REQUEST', Provider\Request\ServiceProvider::class),
                Provider\Response\ServiceProvider::class => Env::get('PROVIDER_RESPONSE', Provider\Response\ServiceProvider::class),
                
                // Security
                Provider\Acl\ServiceProvider::class => Env::get('PROVIDER_ACL', Provider\Acl\ServiceProvider::class),
                Provider\Security\ServiceProvider::class => Env::get('PROVIDER_SECURITY', Provider\Security\ServiceProvider::class),
                Provider\Session\ServiceProvider::class => Env::get('PROVIDER_SESSION', Provider\Session\ServiceProvider::class),
                Provider\Cookies\ServiceProvider::class => Env::get('PROVIDER_COOKIES', Provider\Cookies\ServiceProvider::class),
                Provider\Crypt\ServiceProvider::class => Env::get('PROVIDER_CRYPT', Provider\Crypt\ServiceProvider::class),
                Provider\Filter\ServiceProvider::class => Env::get('PROVIDER_FILTER', Provider\Filter\ServiceProvider::class),
                Provider\Jwt\ServiceProvider::class => Env::get('PROVIDER_JWT', Provider\Jwt\ServiceProvider::class),
                Provider\ReCaptcha\ServiceProvider::class => Env::get('PROVIDER_CAPTCHA', Provider\ReCaptcha\ServiceProvider::class),
                
                // Language
                Provider\Locale\ServiceProvider::class => Env::get('PROVIDER_LOCALE', Provider\Locale\ServiceProvider::class),
                Provider\Translate\ServiceProvider::class => Env::get('PROVIDER_TRANSLATE', Provider\Translate\ServiceProvider::class),
                
                // View
                Provider\View\ServiceProvider::class => Env::get('PROVIDER_VIEW', Provider\View\ServiceProvider::class),
                Provider\Url\ServiceProvider::class => Env::get('PROVIDER_URL', Provider\Url\ServiceProvider::class),
                Provider\Volt\ServiceProvider::class => Env::get('PROVIDER_VOLT', Provider\Volt\ServiceProvider::class),
                Provider\Tag\ServiceProvider::class => Env::get('PROVIDER_TAG', Provider\Tag\ServiceProvider::class),
                Provider\Assets\ServiceProvider::class => Env::get('PROVIDER_ASSETS', Provider\Assets\ServiceProvider::class),
                Provider\Flash\ServiceProvider::class => Env::get('PROVIDER_FLASH', Provider\Flash\ServiceProvider::class),
                Provider\Escaper\ServiceProvider::class => Env::get('PROVIDER_ESCAPER', Provider\Escaper\ServiceProvider::class),
                
                // Database & Models
                Provider\Database\ServiceProvider::class => Env::get('PROVIDER_DATABASE', Provider\Database\ServiceProvider::class),
                Provider\DatabaseReadOnly\ServiceProvider::class => Env::get('PROVIDER_DATABASE_READ_ONLY', Provider\DatabaseReadOnly\ServiceProvider::class),
                Provider\ModelsManager\ServiceProvider::class => Env::get('PROVIDER_MODELS_MANAGER', Provider\ModelsManager\ServiceProvider::class),
                
                // Profiling & Logging
                Provider\Profiler\ServiceProvider::class => Env::get('PROVIDER_PROFILER', Provider\Profiler\ServiceProvider::class),
                Provider\Logger\ServiceProvider::class => Env::get('PROVIDER_LOGGER', Provider\Logger\ServiceProvider::class),
                
                // Caching
                Provider\Annotations\ServiceProvider::class => Env::get('PROVIDER_ANNOTATIONS', Provider\Annotations\ServiceProvider::class),
                Provider\ModelsMetadata\ServiceProvider::class => Env::get('PROVIDER_MODELS_METADATA', Provider\ModelsMetadata\ServiceProvider::class),
                Provider\ModelsCache\ServiceProvider::class => Env::get('PROVIDER_MODELS_CACHE', Provider\ModelsCache\ServiceProvider::class),
                Provider\Cache\ServiceProvider::class => Env::get('PROVIDER_CACHE', Provider\Cache\ServiceProvider::class),
                
                // Identity & Auth
                Provider\Identity\ServiceProvider::class => Env::get('PROVIDER_IDENTITY', Provider\Identity\ServiceProvider::class),
                Provider\Oauth2Client\ServiceProvider::class => Env::get('PROVIDER_OAUTH_2_FACEBOOK', Provider\Oauth2Client\ServiceProvider::class),
                Provider\Oauth2Facebook\ServiceProvider::class => Env::get('PROVIDER_OAUTH_2_FACEBOOK', Provider\Oauth2Facebook\ServiceProvider::class),
                Provider\Oauth2Google\ServiceProvider::class => Env::get('PROVIDER_OAUTH_2_GOOGLE', Provider\Oauth2Google\ServiceProvider::class),
    
                // Mailing
                Provider\Mailer\ServiceProvider::class => Env::get('PROVIDER_MAILER', Provider\Mailer\ServiceProvider::class),
                Provider\Imap\ServiceProvider::class => Env::get('PROVIDER_IMAP', Provider\Imap\ServiceProvider::class),
                
                // Others
                Provider\Version\ServiceProvider::class => Env::get('PROVIDER_VERSION', Provider\Version\ServiceProvider::class),
                Provider\Helper\ServiceProvider::class => Env::get('PROVIDER_HELPER', Provider\Helper\ServiceProvider::class),
                Provider\FileSystem\ServiceProvider::class => Env::get('PROVIDER_FILE_SYSTEM', Provider\FileSystem\ServiceProvider::class),
                Provider\Utils\ServiceProvider::class => Env::get('PROVIDER_UTILS', Provider\Utils\ServiceProvider::class),
                Provider\Aws\ServiceProvider::class => Env::get('PROVIDER_AWS', Provider\Aws\ServiceProvider::class),
                Provider\OCR\ServiceProvider::class => Env::get('PROVIDER_OCR', Provider\OCR\ServiceProvider::class),
                Provider\Gravatar\ServiceProvider::class => Env::get('PROVIDER_GRAVATAR', Provider\Gravatar\ServiceProvider::class),
                Provider\Clamav\ServiceProvider::class => Env::get('PROVIDER_CLAMAV', Provider\Clamav\ServiceProvider::class),
                Provider\OpenAi\ServiceProvider::class => Env::get('PROVIDER_OPENAI', Provider\OpenAi\ServiceProvider::class),
                Provider\LoremIpsum\ServiceProvider::class => Env::get('PROVIDER_LOREM_IPSUM', Provider\LoremIpsum\ServiceProvider::class),
            ],
            
            /**
             * Helper Services
             */
            'helpers' => [
            ],
            
            /**
             * Filter Services
             */
            'filters' => [
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
             * Default modules
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
                \Zemit\Mvc\Module::NAME_OAUTH2 => [
                    'className' => \Zemit\Modules\Oauth2\Module::class,
                    'path' => CORE_PATH . 'Modules/Oauth2/Module.php',
                ],
                \Zemit\Cli\Module::NAME_CLI => [
                    'className' => \Zemit\Modules\Cli\Module::class,
                    'path' => CORE_PATH . 'Modules/Cli/Module.php',
                ],
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
                    'namespace' => Env::get('ROUTER_CLI_DEFAULT_NAMESPACE', 'Zemit\\Modules\\Cli\\Tasks'),
                    'module' => Env::get('ROUTER_CLI_DEFAULT_MODULE', 'cli'),
                    'task' => Env::get('ROUTER_CLI_DEFAULT_TASK', 'help'),
                    'action' => Env::get('ROUTER_CLI_DEFAULT_ACTION', 'main'),
                ],
                'notFound' => [
                    'namespace' => Env::get('ROUTER_NOTFOUND_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_NOTFOUND_MODULE', ''),
                    'controller' => Env::get('ROUTER_NOTFOUND_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_NOTFOUND_TASK', 'error'),
                    'action' => Env::get('ROUTER_NOTFOUND_ACTION', 'notFound'),
                ],
                'fatal' => [
                    'namespace' => Env::get('ROUTER_FATAL_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_FATAL_MODULE', ''),
                    'controller' => Env::get('ROUTER_FATAL_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_FATAL_TASK', 'error'),
                    'action' => Env::get('ROUTER_FATAL_ACTION', 'fatal'),
                ],
                'forbidden' => [
                    'namespace' => Env::get('ROUTER_FORBIDDEN_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_FORBIDDEN_MODULE', ''),
                    'controller' => Env::get('ROUTER_FORBIDDEN_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_FORBIDDEN_TASK', 'error'),
                    'action' => Env::get('ROUTER_FORBIDDEN_ACTION', 'forbidden'),
                ],
                'unauthorized' => [
                    'namespace' => Env::get('ROUTER_UNAUTHORIZED_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_UNAUTHORIZED_MODULE', ''),
                    'controller' => Env::get('ROUTER_UNAUTHORIZED_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_UNAUTHORIZED_TASK', 'error'),
                    'action' => Env::get('ROUTER_UNAUTHORIZED_ACTION', 'unauthorized'),
                ],
                'maintenance' => [
                    'namespace' => Env::get('ROUTER_MAINTENANCE_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_MAINTENANCE_MODULE', ''),
                    'controller' => Env::get('ROUTER_MAINTENANCE_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_MAINTENANCE_TASK', 'error'),
                    'action' => Env::get('ROUTER_MAINTENANCE_ACTION', 'maintenance'),
                ],
                'error' => [
                    'namespace' => Env::get('ROUTER_ERROR_NAMESPACE', ''),
                    'module' => Env::get('ROUTER_ERROR_MODULE', ''),
                    'controller' => Env::get('ROUTER_ERROR_CONTROLLER', 'error'),
                    'task' => Env::get('ROUTER_ERROR_TASK', 'error'),
                    'action' => Env::get('ROUTER_ERROR_ACTION', 'index'),
                ],
            ],
    
            /**
             * View Configuration
             */
            'view' => [
                'minify' => Env::get('VIEW_MINIFY', false),
                'engines' => Env::get('VIEW_ENGINES', [
                    '.phtml' => \Phalcon\Mvc\View\Engine\Php::class,
                    '.volt' => \Phalcon\Mvc\View\Engine\Volt::class,
//                    '.mhtml' => \Phalcon\Mvc\View\Engine\Mustache::class,
//                    '.twig' => \Phalcon\Mvc\View\Engine\Twig::class,
//                    '.tpl' => \Phalcon\Mvc\View\Engine\Smarty::class
                ]),
            ],
    
            /**
             * Volt Configuration
             */
            'volt' => [
                'autoescape' => Env::get('VOLT_AUTOESCAPE', false),
                'always' => Env::get('VOLT_ALWAYS', false),
                'extension' => Env::get('VOLT_EXTENSION', '.php'),
                'separator' => Env::get('VOLT_SEPARATOR', '%%'),
                'path' => Env::get('VOLT_PATH', './'),
                'prefix' => Env::get('VOLT_PREFIX', null),
                'stat' => Env::get('VOLT_STAT', true), // Whether Phalcon must check if there are differences between the template file and its compiled path
            ],
            
            /**
             * Gravatar Configuration
             */
            'gravatar' => [
                'default_image' => Env::get('GRAVATAR_DEFAULT_IMAGE', 'identicon'),
                'size' => Env::get('GRAVATAR_SIZE', 24),
                'rating' => Env::get('GRAVATAR_RATING', 'pg'),
                'use_https' => Env::get('GRAVATAR_USE_HTTPS', true),
            ],
            
            /**
             * reCaptcha Configuration
             */
            'reCaptcha' => [
                'siteKey' => Env::get('RECAPTCHA_KEY'),
                'secret' => Env::get('RECAPTCHA_SECRET'),
                'expectedHostname' => Env::get('RECAPTCHA_EXPECTED_HOSTNAME'),
                'expectedApkPackageName' => Env::get('RECAPTCHA_EXPECTED_APK_PACKAGE_NAME'),
                'expectedAction' => Env::get('RECAPTCHA_EXPECTED_ACTION', null),
                'scoreThreshold' => Env::get('RECAPTCHA_SCORE_THRESHOLD', 0.5),
            ],
            
            /**
             * Locale Service Settings
             */
            'locale' => [
                'default' => Env::get('LOCALE_DEFAULT', 'en'),
                'sessionKey' => Env::get('LOCALE_SESSION_KEY', 'zemit-locale'),
                'mode' => Env::get('LOCALE_MODE', Locale::MODE_DEFAULT),
                'allowed' => explode(',', Env::get('LOCALE_ALLOWED', 'en')),
            ],
            
            /**
             * Translate Service Settings
             */
            'translate' => [
                'locale' => explode(',', Env::get('TRANSLATE_LOCALE', 'en_US.utf8')),
                'defaultDomain' => Env::get('TRANSLATE_DEFAULT_DOMAIN', 'messages'),
                'category' => Env::get('TRANSLATE_CATEGORY', defined('LC_MESSAGES')? LC_MESSAGES : 5),
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
                    'prefix' => Env::get('SESSION_PREFIX', Env::get('GLOBAL_PREFIX', 'zemit_') . 'session_'),
                    'uniqueId' => Env::get('SESSION_UNIQUE_ID', Env::get('GLOBAL_PREFIX', 'zemit_')),
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
                    'session.upload_progress.prefix' => Env::get('SESSION_UPLOAD_PROGRESS_PREFIX', Env::get('GLOBAL_PREFIX', 'zemit_') . 'upload_progress_'),
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
                'workFactor' => Env::get('SECURITY_WORK_FACTOR', 12), // workfactor for the phalcon security service
                'hash' => Env::get('SECURITY_HASH', Security::CRYPT_ARGON2ID), // set default hash to sha512
                'salt' => Env::get('SECURITY_SALT', '>mY.Db5fR?k%~<ZWf\}Zh35_IFC]#0Xx'), // salt for the phalcon security service
                'argon2' => [
                    'memoryCost' => Env::get('SECURITY_ARGON2_MEMORY_COST', PASSWORD_ARGON2_DEFAULT_MEMORY_COST),
                    'timeCost' => Env::get('SECURITY_ARGON2_TIME_COST', PASSWORD_ARGON2_DEFAULT_TIME_COST),
                    'threads' => Env::get('SECURITY_ARGON2_THREADS', PASSWORD_ARGON2_DEFAULT_THREADS),
                ],
                'jwt' => [
                    'signer' => Env::get('SECURITY_JWT_SIGNER', \Phalcon\Encryption\Security\JWT\Signer\Hmac::class),
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
             * Default crypt settings
             * @todo
             */
            'crypt' => [
                'cipher' => Env::get('CRYPT_CIPHER', 'aes-256-cfb'),
                'hash' => Env::get('CRYPT_HASH', 'sha256'),
                'useSigning' => Env::get('CRYPT_USE_SIGNING', false),
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
                    'prefix' => Env::get('CACHE_PREFIX', Env::get('GLOBAL_PREFIX', 'zemit_') . 'cache_'),
                    'lifetime' => Env::get('CACHE_LIFETIME', 86400),
                    'defaultSerializer' => Env::get('CACHE_DEFAULT_SERIALIZER', 'Php'),
                ],
            ],
            
            /**
             * Metadata Configuration
             */
            'metadata' => [
                'driverCli' => Env::get('METADATA_DRIVER_CLI', 'memory'),
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
                ],
                'default' => [
                    'lifetime' => Env::get('METADATA_LIFETIME', 172800),
                    'prefix' => Env::get('METADATA_PREFIX', Env::get('GLOBAL_PREFIX', 'zemit_') . 'metadata_'),
                ],
            ],
            
            /**
             * Annotations Configuration
             * - Memory
             * - Apcu
             * - Stream
             */
            'annotations' => [
                'driver' => Env::get('ANNOTATIONS_DRIVER', 'memory'),
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
                ],
                'default' => [
                    'prefix' => Env::get('ANNOTATIONS_PREFIX', Env::get('GLOBAL_PREFIX', 'zemit_') . 'annotations_'),
                    'lifetime' => Env::get('ANNOTATIONS_LIFETIME', 86400),
                ],
            ],
            
            /**
             * Database configuration
             */
            'database' => [
                'default' => Env::get('DATABASE_ADAPTER', 'mysql'),
                'drivers' => [
                    'mysql' => [
                        'adapter' => Env::get('DATABASE_MYSQL_ADAPTER', \Zemit\Db\Adapter\Pdo\Mysql::class),
                        'dialectClass' => Env::get('DATABASE_DIALECT_CLASS', \Zemit\Db\Dialect\Mysql::class),
                        'host' => Env::get('DATABASE_HOST', 'localhost'),
                        'port' => Env::get('DATABASE_PORT', 3306),
                        'dbname' => Env::get('DATABASE_DBNAME', ''),
                        'username' => Env::get('DATABASE_USERNAME', 'root'),
                        'password' => Env::get('DATABASE_PASSWORD', ''),
                        'charset' => Env::get('DATABASE_CHARSET', 'utf8'),
                        'options' => [
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . Env::get('DATABASE_CHARSET', 'utf8') .
                            ', sql_mode = \'' . Env::get('DATABASE_SQL_MODE', 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION') . '\'',
                            PDO::ATTR_EMULATE_PREPARES => Env::get('DATABASE_PDO_EMULATE_PREPARES', false), // https://stackoverflow.com/questions/10113562/pdo-mysql-use-pdoattr-emulate-prepares-or-not
                            PDO::ATTR_STRINGIFY_FETCHES => Env::get('DATABASE_PDO_STRINGIFY_FETCHES', false),
                            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => Env::get('MYSQL_ATTR_SSL_VERIFY_SERVER_CERT', true),
                            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => Env::get('MYSQL_ATTR_USE_BUFFERED_QUERY', true),
                        ],
                        /**
                         * Readonly Configuration
                         */
                        'readonly' => [
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
             * FileSystem
             * https://flysystem.thephpleague.com/docs/
             */
            'fileSystem' => [
                'driver' => Env::get('FILE_SYSTEM_DRIVER', 'local'),
                'drivers' => [
                    'local' => [
                        'rootDirectory' => Env::get('FILE_SYSTEM_LOCAL_ROOT_DIRECTORY', ROOT_PATH)
                    ],
                    'ftp' => [
                        'host' => Env::get('FILE_SYSTEM_FTP_HOST'), // required
                        'root' => Env::get('FILE_SYSTEM_FTP_ROOT'), // required
                        'username' => Env::get('FILE_SYSTEM_FTP_USERNAME'), // required
                        'password' => Env::get('FILE_SYSTEM_FTP_PASSWORD'), // required
                        'port' => Env::get('FILE_SYSTEM_FTP_PORT', 21),
                        'ssl' => Env::get('FILE_SYSTEM_FTP_SSL', false),
                        'timeout' => Env::get('FILE_SYSTEM_FTP_TIMEOUT', 10),
                        'utf8' => Env::get('FILE_SYSTEM_FTP_UTF8', false),
                        'passive' => Env::get('FILE_SYSTEM_FTP_PASSIVE', true),
                        'transferMode' => Env::get('FILE_SYSTEM_FTP_TRANSFER_MODE', defined('FTP_BINARY')? FTP_BINARY : 2),
                        'systemType' => Env::get('FILE_SYSTEM_FTP_SYSTEM_TYPE'), // windows or unix
                        'ignorePassiveAddress' => Env::get('FILE_SYSTEM_FTP_SYSTEM_IGNORE_PASSIVE_ADDRESS'), // true or false
                        'timestampsOnUnixListingsEnabled' => Env::get('FILE_SYSTEM_FTP_TIMESTAMPS_ON_UNIX_LISTING_ENABLED', false), // true or false
                        'recurseManually' => Env::get('FILE_SYSTEM_FTP_RECURSE_MANUALLY', true), // true or false
                    ],
                    'sftp' => [
                        'host' => Env::get('FILE_SYSTEM_SFTP_HOST'), // required
                        'username' => Env::get('FILE_SYSTEM_SFTP_USERNAME'), // required
                        'password' => Env::get('FILE_SYSTEM_SFTP_PASSWORD'), // set to null if privateKey is used
                        'privateKey' => Env::get('FILE_SYSTEM_SFTP_PRIVATE_KEY'), // can be used instead of password, set to null if password is set
                        'passphrase' => Env::get('FILE_SYSTEM_SFTP_PASSPHRASE'), //  set to null if privateKey is not used or has no passphrase
                        'port' => Env::get('FILE_SYSTEM_SFTP_PORT', 22),
                        'useAgent' => Env::get('FILE_SYSTEM_SFTP_USE_AGENT', false),
                        'timeout' => Env::get('FILE_SYSTEM_SFTP_TIMEOUT', 10),
                        'maxTries' => Env::get('FILE_SYSTEM_SFTP_MAX_TRIES', 4),
                        'hostFingerprint' => Env::get('FILE_SYSTEM_SFTP_HOST_FINGERPRINT'),
                        'connectivityChecker' => Env::get('FILE_SYSTEM_SFTP_CONNECTIVITY_CHECKER'),
                    ],
                    'memory' => [
                        // nothing
                    ],
                    'readOnly' => [
                        // nothing
                    ],
                    'awsS3' => [
                        'bucketName' => Env::get('FILE_SYSTEM_AWS_S3_BUCKET_NAME'),
                        'pathPrefix' => Env::get('FILE_SYSTEM_AWS_S3_PATH_PREFIX')
                    ],
                    'googleCloudStorage' => [
                        'bucketName' => Env::get('FILE_SYSTEM_GOOGLE_CLOUD_STORAGE_BUCKET_NAME'),
                        'pathPrefix' => Env::get('FILE_SYSTEM_GOOGLE_CLOUD_STORAGE_PATH_PREFIX')
                    ],
                    'azureBlobStorage' => [
                        'containerName' => Env::get('FILE_SYSTEM_AZURE_BLOB_STORAGE_CONTAINER_NAME'),
                        'pathPrefix' => Env::get('FILE_SYSTEM_AZURE_BLOB_STORAGE_PATH_PREFIX')
                    ],
                    'webdav' => [
                        'baseUri' => Env::get('FILE_SYSTEM_WEBDAV_BASE_URI'),
                        'userName' => Env::get('FILE_SYSTEM_WEBDAV_USERNAME'),
                        'password' => Env::get('FILE_SYSTEM_WEBDAV_PASSWORD'),
                    ],
                    'zipArchive' => [
                        'path' => Env::get('FILE_SYSTEM_ZIP_ARCHIVE_PATH')
                    ],
                ],
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
                    'redirectUri' => Env::get('OAUTH2_GOOGLE_CLIENT_REDIRECT_URI', '/oauth2/google/callback'),
                    'hostedDomain' => Env::get('OAUTH2_GOOGLE_CLIENT_HOSTED_DOMAIN', null), // optional; used to restrict access to users on your G Suite/Google Apps for Business accounts
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
                'organizationId' => Env::get('OPENAI_ORGANIZATION_ID'),
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
            
            'clamav' => [
                'address' => Env::get('CLAMAV_ADDRESS', 'unix:///run/clamd.scan/clamd.sock'),
                'timeout' => Env::get('CLAMAV_TIMEOUT', 30),
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
             * Access Control List (ACL) options
             */
            'acl' => [],
            
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
                            Api\Controllers\WorkspaceController::class => ['*'],
                            Models\Workspace::class => ['*'],
                            Models\WorkspaceLang::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\WorkspaceController::class => [
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
                    
                    'managePhalconMigrationsList' => [
                        'components' => [
                            Api\Controllers\PhalconMigrationsController::class => ['*'],
                            Models\PhalconMigrations::class => ['*'],
                        ],
                        'behaviors' => [
                            Api\Controllers\PhalconMigrationsController::class => [
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
                            Cli\Tasks\CacheTask::class => ['*'],
                            Cli\Tasks\CronTask::class => ['*'],
                            Cli\Tasks\ErrorTask::class => ['*'],
                            Cli\Tasks\DatabaseTask::class => ['*'],
                            Cli\Tasks\DataLifeCycleTask::class => ['*'],
                            Cli\Tasks\HelpTask::class => ['*'],
                            Cli\Tasks\ScaffoldTask::class => ['*'],
                            Cli\Tasks\TsScaffoldTask::class => ['*'],
                            Cli\Tasks\TestTask::class => ['*'],
                            Cli\Tasks\UserTask::class => ['*'],
                        ],
                    ],
                    
                    // Everyone with or without role
                    'everyone' => [
                        'features' => [
                            'base',
                        ],
                        'components' => [
                            Api\Controllers\ClamavController::class => ['*'],
                            Frontend\Controllers\CheckController::class => ['*'],
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
                            'managePhalconMigrationsList',
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
        ], $data);
        
        $data = $this->internalMergeAppend($data, (new WorkspaceConfig())->toArray());
        $data = $this->internalMergeAppend($data, (new TableConfig())->toArray());
        
        parent::__construct($data, $insensitive);
    }
}
