<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Cache;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Bootstrap;
use Zemit\Cache\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Php;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'cache';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $cacheConfig = $config->pathToArray('cache') ?? [];
            
            $driverNameKey = Php::isCli() ? 'cli' : 'driver';
            $driverName = $cacheConfig[$driverNameKey] ?? 'memory';
            $driverOptions = $cacheConfig['drivers'][$driverName] ?? [];
            $defaultOptions = $cacheConfig['default'] ?? [];
            $options = array_merge($defaultOptions, $driverOptions);
            
            $serializerFactory = new SerializerFactory();
            $adapterFactory = new AdapterFactory($serializerFactory);
            $adapter = $adapterFactory->newInstance($driverName, $options);
            
            return new Cache($adapter);
        });
    }
}
