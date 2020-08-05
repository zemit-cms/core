<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Clamav;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

use \Socket\Raw\Factory;
use \Xenolope\Quahog\Client;

/**
 * Class ServiceProvider
 * @todo support windows
 *
 * @link https://github.com/jonjomckay/quahog
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
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
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config')->clamav;
            
            // Create a new socket instance
            $socket = (new Factory())->createClient($config->address ?? 'tcp://127.0.0.1:3310', $config->timeout ?? null);
            
            // Create a new instance of the Client
            $quahog = new Client($socket, 30, PHP_NORMAL_READ);
            
            return $quahog;
        });
    }
}
