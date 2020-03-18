<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ViewCache;

use Phalcon\Cache\Frontend\Output;
use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\ViewCache\ServiceProvider
 *
 * @package Zemit\Provider\ViewCache
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'viewCache';
    
    /**
     * {@inheritdoc}
     *
     * Note: The frontend must always be Phalcon\Cache\Frontend\Output and the
     * service 'viewCache' must be registered as always open (not shared) in
     * the services container (DI).
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config')->cache;
            
            $driver = $config->drivers->{$config->views};
            $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;
            $default = [
                'statsKey' => 'SVC:' . substr(md5($config->prefix), 0, 16) . '_',
                'prefix' => 'PVC_' . $config->prefix,
            ];
            
            return new $adapter(
                new Output(['lifetime' => $config->lifetime]),
                array_merge($driver->toArray(), $default)
            );
        });
    }
}
