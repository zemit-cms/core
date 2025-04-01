<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Request;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Http\Request;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'request';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $requestConfig = $config->pathToArray('request') ?? [];
            
            $forceServerHttps = $requestConfig['forceServerHttps'] ?? false;
            $trustForwardedHeaders = $requestConfig['trustForwardedHeaders'] ?? false;
            
            if ($forceServerHttps || ($trustForwardedHeaders && str_contains($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '', 'https'))) {
                $_SERVER['HTTPS'] = 'on';
            }
            
            $request = new Request();
            $request->setDI($di);
            
            return $request;
        });
    }
}
