<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Cookies;

use Phalcon\Di\DiInterface;
use Phalcon\Http\Response\Cookies;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'cookies';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?bool $useEncryption = null, ?string $signKey = null) use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $options = $config->pathToArray('cookies', []);
    
            $useEncryption ??= $options['useEncryption'] ?? true;
            $signKey ??= $options['signKey'] ?? null;
            
            return new Cookies($useEncryption, $signKey);
        });
    }
}
