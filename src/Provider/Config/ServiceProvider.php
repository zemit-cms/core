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
    public function register(DiInterface $container = null) : void
    {
        // Set shared service in DI
        $container->setShared($this->getName(), function () use ($container) {
            // Launch the config
            $config = new Config();

            // Inject some dynamic variables
            $config->mode = $container->get('bootstrap')->getMode();

            // Merge config with current environment
            $config->mergeEnvConfig();

            // Launch bootstrap prepare raw php configs
//            $di->get('bootstrap')->prepare()->php();

            // Register other providers
//            foreach ($config->providers as $provider) {
//                $container->register(new $provider($container));
//            }

            // Set the config
            return $config;
        });
    }
}
