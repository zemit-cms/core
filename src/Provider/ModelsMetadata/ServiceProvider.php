<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ModelsMetadata;

use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\ModelsMetadata\ServiceProvider
 *
 * @package Zemit\Provider\ModelsMetadata
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsMetadata';

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
                $config = $di->get('config')->metadata;

                $driver   = $config->drivers->{$config->default};
                $adapter  = '\Phalcon\Mvc\Model\Metadata\\' . $driver->adapter;
                $defaults = [
                    'prefix'   => $config->prefix,
                    'lifetime' => $config->lifetime,
                ];

                return new $adapter(
                    array_merge($driver->toArray(), $defaults)
                );
            }
        );
    }
}
