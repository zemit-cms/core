<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Annotations;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Annotations\ServiceProvider
 *
 * @package Zemit\Provider\Annotations
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'annotations';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->annotations;
            
            $driver = $config->drivers->{$config->default};
            $className = $driver->adapter;
            
            $default = [
                'lifetime' => $config->lifetime,
                'prefix' => $config->prefix,
            ];
            
            return new $className(array_merge($driver->toArray(), $default));
        });
    }
}
