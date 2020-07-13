<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Database;

use Phalcon\Di\DiInterface;
use Zemit\Db\Events\Logger;
use Zemit\Db\Events\Profiler;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Database\ServiceProvider
 *
 * @package Zemit\Provider\Database
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'db';
    
    /**
     * {@inheritdoc}
     * Database connection is created based in the parameters defined in the configuration file.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->database;
            $eventsManager = $di->get('eventsManager');
            
            $driver = $config->drivers->{$config->default};
            $adapter = '\Phalcon\Db\Adapter\Pdo\\' . $driver->adapter;
            
            $config = $driver->toArray();
            unset($config['adapter']);
            
            /** @var \Phalcon\Db\Adapter\Pdo $connection */
            $connection = new $adapter($config);
    
            $eventsManager->attach('db', new Logger());
            $eventsManager->attach('db', new Profiler());
            
            $connection->setEventsManager($eventsManager);
//            $connection->setDi($di);
            
            return $connection;
        });
    }
}
