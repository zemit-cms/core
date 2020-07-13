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

/**
 * Zemit\Provider\EventsManager\ServiceProvider
 *
 * @package Zemit\Provider\EventsManager
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'eventsManager';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        $container->setShared($this->getName(), function () {
            $em = new Manager();
            $em->enablePriorities(true);
            return $em;
        });
    }
}
