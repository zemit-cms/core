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

use Phalcon\Mailer\Manager;
use InvalidArgumentException;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Mail\ServiceProvider
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
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            /** @var \Phalcon\Config $config */
            $config = $di->get('config')->mailer;
            $driver = $config->get('default');
            
            switch($driver) {
                case 'smtp':
                case 'mail':
                case 'sendmail':
                    $manager = new Manager($config->drivers->$driver->toArray());
                    $manager->setDI($di);
                    
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
