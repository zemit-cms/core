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
use Zemit\Di\Injectable;

/**
 * Class Services
 * @package Zemit\Bootstrap
 */
class Services extends Injectable
{
    public function __construct(FactoryDefault $di, Config $config = null)
    {
        $this->setDI($di);
        $config ??= $this->config;
        
        // Register providers from config
        if ($config && $config->has('providers')) {
            foreach ($config->providers as $abstractProvider => $concreteProvider) {
                if ($concreteProvider) {
                    if (class_exists($concreteProvider)) {
                        $di->register(new $concreteProvider($di));
                    } else {
                        throw new \Exception('Provider Class \''.$concreteProvider.'\' not found. Unable to register abstract provider \''.$abstractProvider.'\'', 404);
                    }
                }
            }
        }
    }
}
