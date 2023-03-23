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

use Phalcon\Config\ConfigInterface;
use Phalcon\Di\DiInterface;
use Zemit\Locale;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 *
 *
 * @package Zemit\Provider\Locale
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Default values if nothing is provided from the config
     */
    public array $defaultOptions = [
        'default' => 'en',
        'sessionKey' => 'zemit-locale',
        'mode' => Locale::MODE_SESSION_GEOIP,
        'allowed' => ['en'],
    ];
    
    protected string $serviceName = 'locale';
    
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        assert($config instanceof ConfigInterface);
    
        $options = (array)$config->path('locale', $this->defaultOptions);
        
        $di->setShared($this->getName(), function () use ($options) {
            
            return new Locale($options);
        });
    }
}
