<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Locale;

use Phalcon\Di\DiInterface;
use Zemit\Locale;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Flash\ServiceProvider
 *
 * @package Zemit\Provider\Locale
 */
class ServiceProvider extends AbstractServiceProvider
{
    
    // @todo
    const DEFAULT_OPTIONS = [
    
    ];
    
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'locale';
    
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
            
            // get options from config
            $config = $di->get('config');
            if ($config && $config->has('locale')) {
                $options = $config->locale->toArray();
            }
    
            return new Locale($options ?? self::DEFAULT_OPTIONS);
        });
    }
}
