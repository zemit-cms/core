<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Provider\Translate;

use Phalcon\Di\DiInterface;
use Phalcon\Translate\Adapter\Gettext;
use Phalcon\Translate\InterpolatorFactory;
use PhalconKit\Config\ConfigInterface;
use PhalconKit\Locale;
use PhalconKit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'translate';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $translateConfig = $config->pathToArray('translate') ?? [];
            
            $locale = $di->get('locale');
            assert($locale instanceof Locale);
            
            $translate = new Gettext(new InterpolatorFactory(), $translateConfig);
            $translate->setLocale(LC_ALL, [$locale->getLocale() . '.UTF-8']);
            
            return $translate;
        });
    }
}
