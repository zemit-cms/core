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

namespace PhalconKit\Provider\ModelsCache;

use PhalconKit\Provider\Cache\ServiceProvider as CacheServiceProvider;

class ServiceProvider extends CacheServiceProvider
{
    protected string $serviceName = 'modelsCache';
}
