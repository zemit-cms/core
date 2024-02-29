<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Models;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Models;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'models';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            // config
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            // models config (mapping)
            $options = $config->pathToArray('models', []);
            
            return new Models($options);
        });
    }
}
