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

use Phalcon\Db\Adapter\Pdo\AbstractPdo;
use Phalcon\Di\DiInterface;
use Phalcon\Events\ManagerInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Db\Events\Logger;
use Zemit\Db\Events\Profiler;
use Zemit\Db\Events\Security;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'db';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {

            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            $databaseConfig = $config->pathToArray('database') ?? [];
            $driverName = $databaseConfig['default'];
            $driverOptions = $databaseConfig['drivers'][$driverName];
            $adapter = $driverOptions['adapter'] ?? 'Mysql';
            
            // unset some unsupported variables
            unset($driverOptions['adapter']);
            unset($driverOptions['readOnly']);
            
            // set dialect class
            if (!empty($driverOptions['dialectClass'])) {
                $dialectClass = $driverOptions['dialectClass'];
                assert(class_exists($dialectClass));
                $driverOptions['dialectClass'] = new $dialectClass();
            }

            // prepare the new connection
            $adapterClass = '\Phalcon\Db\Adapter\Pdo\\' . $adapter;
            $connection = new $adapterClass($driverOptions);
            assert($connection instanceof AbstractPdo);
            
            // attach events
            $eventsManager = $di->get('eventsManager');
            assert($eventsManager instanceof ManagerInterface);
            $eventsManager->attach('db', new Security());
            $eventsManager->attach('db', new Logger());
            $eventsManager->attach('db', new Profiler());
            $connection->setEventsManager($eventsManager);

            return $connection;
        });
    }
}
