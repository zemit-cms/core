<?php

namespace Zemit\Provider\Clamav;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

use \Socket\Raw\Factory;
use \Xenolope\Quahog\Client;

/**
 * Zemit\Provider\Clamav\ServiceProvider
 * @todo support windows
 *
 * @link https://github.com/jonjomckay/quahog
 *
 * @package Zemit\Provider\Clamav
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'clamav';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di) : void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->clamav;
            
            // Create a new socket instance
            $socket = (new Factory())->createClient($config->address ?? 'tcp://127.0.0.1:3310', $config->timeout ?? null);

            // Create a new instance of the Client
            $quahog = new Client($socket, 30, PHP_NORMAL_READ);
            
            return $quahog;
        });
    }
}
