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
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Config\ConfigInterface;
use Zemit\Locale;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Default values if nothing is provided from the config
     */
    public array $defaultOptions = [
        'default' => 'en',
        'sessionKey' => 'zemit-locale',
        'mode' => Locale::MODE_DEFAULT,
        'allowed' => ['en'],
    ];
    
    protected string $serviceName = 'locale';
    
    public function register(DiInterface $di): void
    {
        $defaultOptions = $this->defaultOptions;
        
        $di->setShared($this->getName(), function (?array $options = null) use ($di, $defaultOptions) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $options ??= $config->pathToArray('locale', $defaultOptions);
            return new Locale($options);
        });
    }
}
