<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Bootstrap;

use Phalcon\DI\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Zemit\Di\Injectable;
use Zemit\Exception;

class Services extends Injectable
{
    /**
     * @throws Exception
     */
    public function __construct(FactoryDefault $di, ?array $providers = null)
    {
        $this->setDI($di);
    
        // fetch providers from config
        $providers ??= $this->config->pathToArray('providers') ?? [];
        
        // Register providers
        foreach ($providers as $expected => $actual) {
            if (is_string($actual)) {
                if (class_exists($actual)) {
                    $di->register(new $actual($di));
                } else {
                    throw new Exception('Service Provider Class `' . $actual . '` not found. Unable to register Service Provider `' . $expected . '`', 404);
                }
            }
            elseif ($actual instanceof ServiceProviderInterface) {
                $di->register($actual);
            } else {
                throw new Exception('Unable to register Service Provider `' . $expected . '`. Type `' . gettype($actual) . '` is not valid.', 400);
            }
        }
    }
}
