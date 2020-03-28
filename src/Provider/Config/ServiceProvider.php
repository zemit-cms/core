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
use Zemit\Bootstrap\Config;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Config\ServiceProvider
 *
 * @package Zemit\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'config';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di = null) : void
    {
        // Set shared service in DI
        $di->setShared($this->getName(), function () use ($di) {
            $bootstrap = $di->get('bootstrap');
    
            // Launch the config
            $config = new Config();

            // Inject some dynamic variables
            $config->mode = $di->get('bootstrap')->getMode();

            // Merge config with current environment
            $config->mergeEnvConfig();
            // Launch bootstrap prepare raw php configs
            $bootstrap->prepare()->php($config->app ?? null);

            // Register other providers
            foreach ($config->providers as $provider) {
                $di->register(new $provider($di));
            }

            // Set the config
            return $config;
        });
    }
}
