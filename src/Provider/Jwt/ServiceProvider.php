<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Jwt;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'jwt';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $jwtConfig = $config->pathToArray('security.jwt') ?? [];
            return new Jwt($jwtConfig);
        });
    }
}
