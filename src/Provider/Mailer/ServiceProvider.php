<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Mailer;

use Phalcon\Config\ConfigInterface;
use Phalcon\Di\DiInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mailer\Manager;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'mailer';
    
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        assert($config instanceof ConfigInterface);
    
        $mailerConfig = (array)$config->get('mailer');
        
        $di->setShared($this->getName(), function () use ($di, $mailerConfig) {
            
            $driver = $mailerConfig['driver'] ?? '';
            $defaultOptions = $mailerConfig['defaults'] ?? [];
            $driverOptions = $mailerConfig['drivers'][$driver] ?? [];
            $options = array_merge($defaultOptions, $driverOptions);
    
            $manager = new Manager($options);
            $manager->setDI($di);
            
            $eventsManager = $di->get('eventsManager');
            if ($eventsManager instanceof ManagerInterface) {
                $manager->setEventsManager($eventsManager);
            }
        });
    }
}
