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

namespace Zemit\Provider\ModelsManager;

use Phalcon\Di\DiInterface;
use Phalcon\Events\ManagerInterface;
use Zemit\Mvc\Model\Manager;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'modelsManager';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $manager = new Manager();
    
            $eventsManager = $di->get('eventsManager');
            if ($eventsManager instanceof ManagerInterface) {
                $manager->setEventsManager($eventsManager);
            }
            
            return $manager;
        });
    }
}
