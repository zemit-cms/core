<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Config;

use Phalcon\Di\DiInterface;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Php;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'config';
    
    protected ConfigInterface $config;
    
    public function register(DiInterface $di = null): void
    {
        // Set shared service in DI
        $di->setShared($this->getName(), function () use ($di) {
    
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $bootstrap->config ??= new Config();
            
            // Merge config with current environment
            $bootstrap->config->mergeEnvConfig();
            
            // Launch bootstrap prepare raw php configs
            Php::set($bootstrap->config->pathToArray('app') ?? []);
            
            // Set the config
            return $bootstrap->config;
        });
    }
}
