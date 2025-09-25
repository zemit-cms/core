<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\WebSocket;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Ws\WebSocket;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'webSocket';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            return new WebSocket($di);
        });
    }
}
