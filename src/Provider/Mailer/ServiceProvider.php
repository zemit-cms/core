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

use Phalcon\Di\DiInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Incubator\Mailer\Manager;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'mailer';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            $mailerConfig = $config->pathToArray('mailer', []);
            
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
            
            // temporary fix for smtp auth
            if ($driver === 'smtp') {
                $manager->getMailer()->SMTPAuth = true;
            }
            
            return $manager;
        });
    }
}
