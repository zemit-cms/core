<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Mailer;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Mailer\Manager;
use InvalidArgumentException;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Mailer
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'mailer';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            
            /** @var \Phalcon\Config $config */
            $config = $di->get('config');
            
            /** @var \Phalcon\Config|string $driver */
            $driver = $config->path('mailer.driver', 'sendmail');
            
            /** @var \Phalcon\Events\Manager $eventsManager */
            $eventsManager = $di->get('eventsManager');
            
            switch($driver) {
                case 'smtp':
                case 'mail':
                case 'sendmail':
                    // Get the mailer manager settings
                    $settings = $config->path('mailer.drivers.' . $driver, []);
                    $settings = $settings instanceof Config? $settings->toArray() : $settings;
                    
                    // Get the mailer manager default settings
                    $default = $config->path('mailer.default', []);
                    $default = $default instanceof Config? $default->toArray() : $default;
                    
                    // Merge default settings
                    $settings = array_merge($settings, $default);
                    
                    // Prepare the mailer manager
                    $manager = new Manager($settings);
                    
                    // Bind the DI
                    $manager->setDI($di);
                    
                    // Bind the global event manager
                    $manager->setEventsManager($eventsManager);
                    
                    return $manager;
            }
            
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid mail driver. Expected either "smtp" or "mail" or "sendmail". Got "%s".',
                    is_scalar($driver) ? $driver : var_export($driver, true)
                )
            );
        });
    }
}
