<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Loggers;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Logger\Loggers;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'loggers';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $options = $config->pathToArray('logger') ?? [];
            $options['loggers'] = $config->pathToArray('loggers') ?? [];
            
            return new Loggers($options);
        });
    }
}
