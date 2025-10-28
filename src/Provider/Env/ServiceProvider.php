<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Env;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Env;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'env';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), Env::class);
    }
}
