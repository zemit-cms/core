<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Volt;

use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewInterface;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'volt';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $view = $di->get('view');
            assert($view instanceof ViewInterface);
    
            $voltConfig = $config->pathToArray('volt') ?? [];
            
            $volt = new Volt($view, $di);
            $volt->setOptions($voltConfig);
            
            return $volt;
        });
    }
}
