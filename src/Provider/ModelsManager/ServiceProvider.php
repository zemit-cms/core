<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ModelsManager;

use Phalcon\Mvc\Model\Manager;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\ModelsManager\ServiceProvider
 *
 * @package Zemit\Provider\ModelsManager
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsManager';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di) : void
    {
        $di->setShared(
            $this->getName(),
            function () use ($di) {
                $modelsManager = new Manager();
                $modelsManager->setEventsManager($di->get('eventsManager'));

                return $modelsManager;
            }
        );
    }
}
