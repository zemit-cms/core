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
use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Adapter\Noop;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'session';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $sessionConfig = $config->pathToArray('session');
            
            $driverName = $sessionConfig['driver'] ?? '';
            
            $defaultOptions = $sessionConfig['default'] ?? [];
            $driverOptions = $sessionConfig['drivers'][$driverName] ?? [];
            $options = array_merge($defaultOptions, $driverOptions);
            
            // ini_set
            $sessionIniConfig = $sessionConfig['ini'] ?? [];
            foreach ($sessionIniConfig as $sessionIniKey => $sessionIniValue) {
                @ini_set($sessionIniKey, $sessionIniValue); // @todo remove @ and avoid this during unit testing
            }
            
            // Create the new session manager
            $session = new Manager();
            
            // Set the storage adapter
            $adapter = $options['adapter'];
            if (in_array($adapter, [Noop::class, Stream::class])) {
                $session->setAdapter(new $adapter($options));
            }
            else {
                $serializerFactory = new SerializerFactory();
                $adapterFactory = new AdapterFactory($serializerFactory);
                $session->setAdapter(new $adapter($adapterFactory, $options));
                
                // ini_set save_handler and save_path for redis
                if ($adapter instanceof Redis) {
                    ini_set('session.save_handler', 'redis');
                    ini_set('session.save_path', $options['host'] . ':' . $options['port'] . '?' . http_build_query($options));
                }
            }
            
            // Start and return the session
            $session->start();
            return $session;
        });
    }
}
