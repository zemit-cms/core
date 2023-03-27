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
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'config';
    
    public function register(DiInterface $di = null): void
    {
        // Set shared service in DI
        $di->setShared($this->getName(), function () use ($di) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $config = $bootstrap->config ?? new Config();
            
            if (is_string($config) && class_exists($config)) {
                $config = new $config();
            }
            
            // Set bootstrap mode into config
            $config->mode = $di->get('bootstrap')->getMode();
            
            // Merge config with current environment
            $config->mergeEnvConfig();
            
            // Launch bootstrap prepare raw php configs
            $bootstrap->prepare->php($config->pathToArray('app') ?? []);
            
            // Set the config
            return $config;
        });
    }
}
