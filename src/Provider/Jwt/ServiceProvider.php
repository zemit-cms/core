<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Jwt;

use Lcobucci\JWT\Builder;
use Phalcon\Di\DiInterface;
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
    protected $serviceName = 'jwt';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di) : void
    {
        $di->setShared($this->getName(), function () use ($di) {
            return true; //@todo
        });
    }
}
