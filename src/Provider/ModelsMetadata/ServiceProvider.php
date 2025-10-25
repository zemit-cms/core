<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ModelsMetadata;

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Model\MetaData\Memory;
use Phalcon\Mvc\Model\MetaData\Stream;
use Phalcon\Storage\SerializerFactory;
use Zemit\Bootstrap;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Php;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'modelsMetadata';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $metadataConfig = $config->pathToArray('metadata') ?? [];
            
            $driverKey = Php::isCli() ? 'driverCli' : 'driver';
            $driverName = $metadataConfig[$driverKey] ?? 'memory';
            $driver = $metadataConfig['drivers'][$driverName] ?? [];
            $default = $metadataConfig['default'] ?? [];
            $options = array_merge($default, $driver);
            
            assert(is_string($driver['adapter']));
            
            $adapter = $driver['adapter'] ?? Memory::class;
            if (in_array($adapter, [Memory::class, Stream::class])) {
                return new $adapter($options);
            }

            $serializerFactory = new SerializerFactory();
            $adapterFactory = new AdapterFactory($serializerFactory);
            return new $adapter($adapterFactory, $options);
        });
    }
}
