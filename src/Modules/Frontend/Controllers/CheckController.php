<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Frontend\Controllers;

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Http\Response;
use Phalcon\Messages\Message;
use Phalcon\Filter\Validation;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Escaper;
use Phalcon\Filter;
use Zemit\Http\Request;
use Zemit\Identity;
use Zemit\Locale;
use Zemit\Mvc\Application;
use Zemit\Mvc\Dispatcher;
use Zemit\Mvc\Router;
use Zemit\Mvc\Url;
use Zemit\Utils;

class CheckController extends AbstractController
{
    public array $versionList = [
        'php' => '8.2',
        'phalcon' => '5.4',
        'zemit' => '0.5',
    ];
    
    public array $phpExtensionList = [
        // lel
        'Core',
        'phalcon',
        
        // https://docs.phalcon.io/4.0/en/installation
        'curl',
        'fileinfo',
        'gettext',
        'gd',
        'imagick',
        'json',
        'PDO',
        'OpenSSL',
        'Mbstring',
        'Memcached',
        'psr',
        
        // Basic stuff
        'intl',
        'pdo',
        'bcmath',
        'json',
        'xml',
        'env',
        'exif',
        'redis',
        'memcached',
        'apc',
        'apcu',
        'geoip',
        'mailparse',
        'memcache',
        'memcached',
        'curl',
        'iconv',
        'mysqlnd',
        'dom',
        'zip',
        'rar',
        'yaml',
        'zmq',
        'hash',
        'sodium',
        'enchant',
        'filter',
        'openssl',
        'libxml',
        'date',
    ];
    /**
     * @var string[] Service Classes
     */
    public array $serviceList = [
        // system
        'bootstrap' => Bootstrap::class,
        'config' => Config::class,
        'router' => Router::class,
        'dispatcher' => Dispatcher::class,
        'request' => Request::class,
        'response' => Response::class,
        'application' => Application::class,
        'url' => Url::class,
        'identity' => Identity::class,
        'db' => Mysql::class,
        'escaper' => Escaper::class,
//        'filter' => \Zemit\Filter::class, // @todo make it work
        'filter' => Filter::class,
        'locale' => Locale::class,
        'utils' => Utils::class,
    ];
    
    /**
     * @return array|string[]
     */
    public function getVersionList(): array
    {
        return $this->versionList ?: [];
    }
    
    /**
     * @return array|string[]
     */
    public function getPhpExtensionList(): array
    {
        return $this->phpExtensionList ?: [];
    }
    
    /**
     * @return array|string[]
     */
    public function getServiceList(): array
    {
        return $this->serviceList ?: [];
    }
    
    /**
     * Return the pong response to a ping request
     * @return string
     */
    public function pingAction()
    {
        return 'PONG ' . date('c');
    }
    
    /**
     * Compatibility and requirements checks
     */
    public function requirementsAction()
    {
        $di = $this->getDI();
        $validation = new Validation();
        
        // check versions
        $versionList = $this->getVersionList();
        $phalconVersion = new \Phalcon\Support\Version();
        $zemitVersion = new \Zemit\Support\Version();
        foreach ([
                     'php' => PHP_VERSION,
                     'phalcon' => $phalconVersion->get(),
                     'zemit' => $zemitVersion->get(),
                 ] as $what => $version
        ) {
            if (!version_compare($version, $versionList[$what], '>=')) {
                $validation->appendMessage(new Message('PHP Version Failed `' . $version . '` received but `' . $this->version[$what] . '` >= expected', $what, 'PhpVersionMismatch', 404));
            }
        }
        
        // check php extensions
        $phpExtensionList = $this->getPhpExtensionList();
        foreach ($phpExtensionList as $phpExtension) {
            if (!extension_loaded($phpExtension)) {
                $validation->appendMessage(new Message('PHP Extension Failed `' . $phpExtension . '`', $phpExtension, 'MissingPhpExtension', 404));
            }
        }
        
        // check service providers automagically
        foreach ($this->config->providers as $fromClassName => $toClassName) {
            $provider = new $toClassName($di);
            $providerName = $provider->getName();
            
            // Check if service provider exist
            if (!$di->has($providerName)) {
                $validation->appendMessage(new Message('Provider `' . $providerName . '` not found on `' . $toClassName . '`', $providerName, 'NotFound', 404));
            }
            else {
                // Check if we can load the service provider
                if (!$di->get($providerName)) {
                    $validation->appendMessage(new Message('Provider `' . $providerName . '` not loaded on `' . $toClassName . '`', $providerName, 'BadRequest', 400));
                }
            }
        }
        
        // Check service instance of manually
        $serviceList = $this->getServiceList();
        foreach ($serviceList as $name => $className) {
            if (!($this->$name instanceof $className)) {
                $validation->appendMessage(new Message('`' . $name . '` must be an instance of `' . $className . '`', $name, 'NotValid', 400));
            }
        }
        
        // return that nonsense thing
        $messages = $validation->getMessages();
        if (!empty($messages)) {
            $ret = [];
            foreach ($messages as $message) {
                $ret [] = implode(' - ', [
                    $message->getCode(),
                    $message->getField(),
                    $message->getMessage(),
                    $message->getType(),
                ]);
            }
            
            return implode(PHP_EOL, $ret);
        }
        
        return 'OK';
    }
    
    public function phpinfoAction(): void
    {
        phpinfo();
        exit();
    }
    
    public function extensionsAction(): void
    {
        dd(get_loaded_extensions());
    }
    
    public function cacheAction(): void
    {
        dd(realpath_cache_get());
    }
}
