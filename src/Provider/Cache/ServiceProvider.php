<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Cache;

use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;
use Zemit\Cache\Cache;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\ModelsCache
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'cache';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            
            $config = $di->get('config')->cache;
            $driverName = $di->get('bootstrap')->getMode() === 'console'? 'cli' : 'driver';
            $driver = $config->drivers->{$config->$driverName};
            
            $options = array_merge($config->default->toArray(), $driver->toArray());
            
            $serializerFactory = new SerializerFactory();
            $adapterFactory = new AdapterFactory($serializerFactory);
            $adapter = $adapterFactory->newInstance($config->$driverName, $options);
    
            return new Cache($adapter);
        });
    }
}
