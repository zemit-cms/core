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
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\DiInterface;
use Phalcon\Events\ManagerInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Db\Events\Logger;
use Zemit\Db\Events\Profiler;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected bool $readonly = false;
    protected string $serviceName = 'db';
    
    public function register(DiInterface $di): void
    {
        $readonly = $this->readonly;
        $di->setShared($this->getName(), function () use ($di, $readonly) {

            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            // database config
            $databaseConfig = $config->pathToArray('database') ?? [];
            $driverName = $databaseConfig['default'] ?? 'mysql';
            $driverOptions = $databaseConfig['drivers'][$driverName] ?? [];
            
            // readonly
            if (!$readonly) {
                $readonlyOptions = array_filter($driverOptions['readonly'] ?? [], function ($value) {
                    return !is_null($value);
                });
                $driverOptions = array_merge($driverOptions, $readonlyOptions);
                unset($driverOptions['readonly']);
                unset($driverOptions['enable']);
            }
            
            // dialect
            if (!empty($driverOptions['dialectClass'])) {
                $dialectClass = $driverOptions['dialectClass'];
                assert(class_exists($dialectClass));
                $driverOptions['dialectClass'] = new $dialectClass();
            }
    
            // adapter
            $adapter = $driverOptions['adapter'] ?? Mysql::class;
            assert(class_exists($adapter));
            unset($driverOptions['adapter']);

            // connection
            $connection = new $adapter($driverOptions);
            assert($connection instanceof AbstractPdo);
            
            // attach events
            $eventsManager = $di->get('eventsManager');
            assert($eventsManager instanceof ManagerInterface);
            $eventsManager->attach('db', new Logger());
            $eventsManager->attach('db', new Profiler());
            $connection->setEventsManager($eventsManager);

            return $connection;
        });
    }
}
