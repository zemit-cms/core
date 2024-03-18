<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Filter;

use Phalcon\Di\DiInterface;
use Zemit\Filter\FilterFactory;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'filter';
    
    public function register(DiInterface $di): void
    {
        $di->set($this->getName(), function () use ($di) {

            $locator = (new FilterFactory())->newInstance();
            
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
