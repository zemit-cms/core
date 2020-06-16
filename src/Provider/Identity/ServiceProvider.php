<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Identity;

use Phalcon\Di\DiInterface;
use Zemit\Identity;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Identity\ServiceProvider
 *
 * @package Zemit\Provider\Identity
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'identity';
    
    /**
     * {@inheritdoc}
     *
     * Register the Flash Service with the Twitter Bootstrap classes.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config');
            
            if ($config && $config->has('identity')) {
                $options = $config->identity->toArray();
            }
            
            $identity = new Identity($options ?? null);
            
            return $identity;
        });
    }
}
