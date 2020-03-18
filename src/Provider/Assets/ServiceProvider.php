<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Assets;

use Zemit\Assets\Manager;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Assets\ServiceProvider
 *
 * @package Zemit\Provider\Assets
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'assets';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di) : void
    {
        $di->setShared($this->getName(), Manager::class);
    }
}
