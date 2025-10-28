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

namespace Zemit\Provider\Identity;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Identity\Manager as Identity;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'identity';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?array $options = null) use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $options ??= $config->pathToArray('identity');
            
            $identity = new Identity($options);
            $identity->setDI($di);
            
            return $identity;
        });
    }
}
