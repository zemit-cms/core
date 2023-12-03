<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Helper;

use Phalcon\Di\DiInterface;
use Phalcon\Support\HelperFactory;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'helper';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $helper = new HelperFactory();
            
            // @todo fetch config to allow to push classes into the helper factory
            
            return $helper;
        });
    }
}
