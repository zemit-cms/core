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

namespace Zemit\Provider\Escaper;

use Phalcon\Di\DiInterface;
use Zemit\Html\Escaper;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'escaper';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->set($this->getName(), Escaper::class);
    }
}
