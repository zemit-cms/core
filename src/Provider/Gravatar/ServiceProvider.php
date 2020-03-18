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

use Phalcon\Avatar\Gravatar;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Avatar\ServiceProvider
 *
 * @package Zemit\Provider\Avatar
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'gravatar';

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
                return new Gravatar($di->get('config')->get('gravatar'));
            }
        );
    }
}
