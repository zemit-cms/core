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

namespace PhalconKit\Provider\Filter;

use Phalcon\Di\DiInterface;
use PhalconKit\Filter\Filter;
use PhalconKit\Filter\FilterFactory;
use PhalconKit\Config\ConfigInterface;
use PhalconKit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'filter';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->set($this->getName(), function () use ($di) {

            $locator = (new FilterFactory())->newInstance();
            assert($locator instanceof Filter);
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $filterServices = $config->pathToArray('filters') ?? [];
            foreach ($filterServices as $key => $filter) {
                $locator->set($key, $filter);
            }
            
            return $locator;
        });
    }
}
