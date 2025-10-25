<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Gravatar;

//use Phalcon\Avatar\Gravatar;
use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'gravatar';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        // @todo implement based on https://github.com/phalcon/incubator-avatar/blob/master/src/Gravatar.php
//        $di->setShared($this->getName(), function (?array $options = null) use ($di) {
//    
//            $config = $di->get('config');
//            assert($config instanceof ConfigInterface);
//    
//            $options ??= $config->pathToArray('gravatar', []);
//            
//            return new Gravatar($options);
//        });
    }
}
