<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Aws;

use Aws\Sdk;
use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'aws';
    
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        assert($config instanceof ConfigInterface);
        
        $di->setShared($this->getName(), function () use ($config) {
            
            $options = $config->pathToArray('aws', []);
            return new Sdk($options);
        });
    }
}
