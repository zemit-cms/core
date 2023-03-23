<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Annotations;

use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'annotations';
    
    public function register(DiInterface $di): void
    {
        // config
        $config = $di->get('config');
        assert($config instanceof ConfigInterface);
        $annotationsConfig = $config->pathToArray('annotations');
    
        // options
        $driverName = $annotationsConfig['driver'] ?? 'memory';
        $driverOptions = $annotationsConfig['drivers'][$driverName] ?? [];
        $defaultOptions = $annotationsConfig['default'] ?? [];
        $options = array_merge($defaultOptions, $driverOptions);
        
        // adapter
        $adapter = $driverOptions['adapter'] ?: Memory::class;
        
        $di->setShared($this->getName(), function () use ($adapter, $options) {
            
            return new $adapter($options);
        });
    }
}
