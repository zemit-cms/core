<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Crypt;

use Phalcon\Di\DiInterface;
use Phalcon\Encryption\Crypt;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'crypt';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?string $cipher = null, ?bool $useSigning = null) use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $options = $config->pathToArray('crypt', []);
            
            $cipher ??= $options['cipher'] ?? 'aes-256-cfb';
            $useSigning ??= $options['useSigning'] ?? false;
            
            return new Crypt($cipher, $useSigning);
        });
    }
}
