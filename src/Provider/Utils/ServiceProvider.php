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

namespace Zemit\Provider\Utils;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Utils;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'utils';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () {
            
            return new Utils();
        });
    }
}
