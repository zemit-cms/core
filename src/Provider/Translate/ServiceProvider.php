<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Translate;

use Phalcon\Di\DiInterface;
use Phalcon\Translate\Adapter\Gettext;
use Phalcon\Translate\InterpolatorFactory;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'translate';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $translateConfig = $config->pathToArray('translate') ?? [];
            
            $translate = new Gettext(new InterpolatorFactory(), $translateConfig);
            $translate->setLocale(LC_MESSAGES, $di->get('locale')->get() . '.utf8');
            
            return $translate;
        });
    }
}
