<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Url;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc;
use Zemit\Mvc\Url;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'url';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $urlConfig = $config->pathToArray('url') ?? [];
            
            $router = $di->get('router');
            $url = new Url($router instanceof Mvc\RouterInterface ? $router : null);
            $url->setStaticBaseUri($urlConfig['staticBaseUri'] ?? '/');
            $url->setBaseUri($urlConfig['baseUri'] ?? '/');
            $url->setBasePath($urlConfig['basePath'] ?? '/');
            $url->setDI($di);
            
            return $url;
        });
    }
}
