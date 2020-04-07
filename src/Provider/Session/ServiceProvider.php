<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */


namespace Zemit\Provider\Session;

use Phalcon\Di\DiInterface;
use Phalcon\Session\Manager;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Session\ServiceProvider
 *
 * @package Zemit\Provider\Session
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'session';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config')->session;
    
            $defaults = [
                'prefix' => $config->prefix,
                'uniqueId' => $config->uniqueId,
                'lifetime' => $config->lifetime,
            ];
    
            $session = new Manager();
            
            if (!empty($config->default)) {
                $driver = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Session\Adapter\\' . $driver->adapter;
                if (class_exists($adapter)) {
                    $session->setAdapter(new $adapter(array_merge($driver ? $driver->toArray() : [], $defaults)));
                }
//                /** @var \Phalcon\Session\AdapterInterface $session */
//                $session = new $adapter(array_merge($driver->toArray(), $defaults));
            }
            
            $session->start();
            return $session;
        });
    }
}
