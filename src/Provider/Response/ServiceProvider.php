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

namespace Zemit\Provider\Response;

use Phalcon\Di\DiInterface;
use Zemit\Http\Response;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'response';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            $response = new Response();
            $response->setDI($di);
            
            $headers = $config->pathToArray('response.headers') ?? [];
            foreach ($headers as $name => $value) {
                $response->setHeader($name, $value);
            }

            return $response;
        });
    }
}
