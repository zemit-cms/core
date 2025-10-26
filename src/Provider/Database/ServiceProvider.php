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
    protected ?string $driverName = null;
    protected string $serviceName = 'db';
    protected static bool $attachedEvents = false;
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $driverName = $this->driverName;
        $di->setShared($this->getName(), function () use ($di, $driverName) {
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            // database config
            $databaseConfig = $config->pathToArray('database') ?? [];
            $driverName ??= $databaseConfig['default'] ?? 'mysql';
            
            // specified driver name
            if (isset($databaseConfig['drivers'][$driverName])) {
                if (!is_array($databaseConfig['drivers'][$driverName])) {
                    throw new \InvalidArgumentException('Database driver option `' . $driverName . '` must be an array');
                }
                
                $driverOptions = array_filter($databaseConfig['drivers'][$driverName], fn(mixed $value) => $value !== null);
                
                if (isset($driverOptions['extends'])) {
                    if (is_string($driverOptions['extends'])) {
                        $driverOptions['extends'] = explode(',', $driverOptions['extends']);
                    }
                    if (is_array($driverOptions['extends'])) {
                        foreach ($driverOptions['extends'] as $extend) {
                            $driverOptions = array_merge($databaseConfig['drivers'][trim($extend)] ?? [], $driverOptions);
                        }
                    }
                }
            }
            
            // default driver name
            else {
                $defaultDriverName = $databaseConfig['default'] ?? 'mysql';
                $driverOptions = $databaseConfig['drivers'][$defaultDriverName] ?? [];
            }
            
            // unset unsupported parameters
            unset($driverOptions['extends']);
            unset($driverOptions['enable']);
            
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
            
            if (!self::$attachedEvents) {
                $eventsManager->detach('db', new Logger());
                $eventsManager->detach('db', new Profiler());
            }
            
            $eventsManager->attach('db', new Logger());
            $eventsManager->attach('db', new Profiler());
            self::$attachedEvents = true;
            
            $connection->setEventsManager($eventsManager);
            
            return $connection;
        });
    }
}
