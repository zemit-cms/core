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
use Phalcon\Config\ConfigInterface;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Model\MetaData\Memory;
use Phalcon\Mvc\Model\MetaData\Stream;
use Phalcon\Storage\SerializerFactory;
use Zemit\Bootstrap;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'modelsMetadata';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $metadataConfig = $config->get('metadata')->toArray();
            
            $driverName = $bootstrap->isCli() ? 'cli' : 'driver';
            $driver = $metadataConfig['drivers'][$metadataConfig[$driverName]] ?? [];
            $options = array_merge($config['default'], $driver);
            
            $adapter = $driver['adapter'] ?? '';
            if (in_array($adapter, [Memory::class, Stream::class])) {
                return new $adapter($options);
            }

            $serializerFactory = new SerializerFactory();
            $adapterFactory = new AdapterFactory($serializerFactory);
            return new $adapter($adapterFactory, $options);
        });
    }
}
