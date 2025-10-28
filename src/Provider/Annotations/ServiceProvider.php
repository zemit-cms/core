<?php

declare(strict_types=1);

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
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            // config
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $annotationsConfig = $config->pathToArray('annotations', []);
    
            // options
            $driverName = $annotationsConfig['driver'] ?? 'memory';
            $driverOptions = $annotationsConfig['drivers'][$driverName] ?? [];
            $defaultOptions = $annotationsConfig['default'] ?? [];
            $options = array_merge($defaultOptions, $driverOptions);
    
            // adapter
            $adapter = $driverOptions['adapter'] ?: Memory::class;
            return new $adapter($options);
        });
    }
}
