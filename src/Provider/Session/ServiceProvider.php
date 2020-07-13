<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */


namespace Zemit\Provider\Session;

use Phalcon\Di\DiInterface;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Noop;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Session\ServiceProvider
 *
 * @package Zemit\Provider\Session
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'session';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->session;
            $driver = $config->drivers->{$config->driver};
            $adapter = $driver->adapter;
    
            // Merge default config with driver config
            $options = array_merge($config->default->toArray(), $driver->toArray());
    
            // Create the new session manager
            $session = new Manager();
            
            // Set the storage adapter
            if (in_array($adapter, [Noop::class, Stream::class])) {
                $session->setAdapter(new $adapter($options));
            } else {
                $serializerFactory = new SerializerFactory();
                $adapterFactory = new AdapterFactory($serializerFactory);
                $session->setAdapter(new $adapter($adapterFactory, $options));
            }
            
            // Start and return the session
            $session->start();
            return $session;
        });
    }
}
