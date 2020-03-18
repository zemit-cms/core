<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Utils;

use Phalcon\Di\DiInterface;
use Zemit\Utils;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Utils\ServiceProvider
 *
 * @package Zemit\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'utils';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(\Phalcon\Di\DiInterface $di) : void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $utils = new Utils();
            return $utils;
        });
    }
}
