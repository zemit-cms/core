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
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        // Set shared service in DI
        $di->setShared($this->getName(), function () use ($di) {
    
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $bootstrap->config ??= new Config();
            $config = $bootstrap->getConfig();
            
            // Launch bootstrap prepare raw php configs
            Php::set($config->pathToArray('app') ?? []);
            
            // Set the config
            return $config;
        });
    }
}
