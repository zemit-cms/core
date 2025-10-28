<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Swoole;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Swoole\WebSocket\Server;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'swoole';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            if (!defined('SWOOLE_LOG_WARNING') || !extension_loaded('swoole')) {
                throw new \LogicException('Swoole not available');
            }
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $swooleConfig = $config->pathToArray('swoole') ?? [];
            
            $swooleConfig['host'] ??= '0.0.0.0';
            $swooleConfig['port'] ??= 8080;
            
            $swooleConfig['settings'] ??= [];
            $swooleConfig['settings']['worker_num'] ??= 1;
            $swooleConfig['settings']['max_conn'] ??= 1000;
            $swooleConfig['settings']['daemonize'] ??= false;
            $swooleConfig['settings']['heartbeat_check_interval'] ??= 60;
            $swooleConfig['settings']['heartbeat_idle_time'] ??= 120;
            $swooleConfig['settings']['log_level'] ??= SWOOLE_LOG_WARNING;
            $swooleConfig['settings']['trace_flags'] ??= 0;

            $server = new Server($swooleConfig['host'], (int)$swooleConfig['port']);
            $server->set($swooleConfig['settings']);
            
            return $server;
        });
    }
}
