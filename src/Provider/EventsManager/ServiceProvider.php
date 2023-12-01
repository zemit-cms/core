<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\EventsManager;

use Phalcon\Di\DiInterface;
use Phalcon\Events\Manager;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'eventsManager';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () {
            
            $eventsManager = new Manager();
            $eventsManager->enablePriorities(true);
            
            return $eventsManager;
        });
    }
}
