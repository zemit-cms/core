<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Profiler;

use Phalcon\Di\DiInterface;
use Zemit\Db\Profiler;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'profiler';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), Profiler::class);
    }
}
