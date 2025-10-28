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

namespace Zemit\Provider\Clamav;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Socket\Raw\Factory;
use Xenolope\Quahog\Client;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'clamav';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?array $options = null) use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            assert(extension_loaded('ext-sockets'));
            
            $options ??= $config->pathToArray('clamav') ?? [];
            $address = $options['address'] ?? 'tcp://127.0.0.1:3310';
            $timeout = $options['timeout'] ?? 30;
            
            // Create a new socket instance
            $socket = (new Factory())->createClient($address, $timeout);
            
            return new Client($socket, $timeout, PHP_NORMAL_READ);
        });
    }
}
