<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ModelsCache;

use Phalcon\Cache\AdapterFactory;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Storage\SerializerFactory;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\ModelsCache\ServiceProvider
 *
 * @package Zemit\Provider\ModelsCache
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsCache';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared(
            $this->getName(),
            function () use ($di) {
                $config = $di->get('config')->cache;
                
                $serializerFactory = new SerializerFactory();
                $adapterFactory = new AdapterFactory($serializerFactory);
                
                $options = [
                    'defaultSerializer' => 'Php',
                    'lifetime' => 7200,
                ];
                
                $adapter = $adapterFactory->newInstance('apcu', $options);
                
                return new Cache($adapter);

            //                $driver  = $config->drivers->{$config->default};
            //                $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;
            //                $default = [
            //                    'statsKey' => 'SMC:'.substr(md5($config->prefix), 0, 16).'_',
            //                    'prefix'   => 'PMC_'.$config->prefix,
            //                ];
            //
            //                return new $adapter(
            //                    new Data(['lifetime' => $config->lifetime]),
            //                    array_merge($driver->toArray(), $default)
            //                );
            }
        );
    }
}
