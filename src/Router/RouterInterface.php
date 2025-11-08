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

namespace PhalconKit\Router;

use Phalcon\Di\InjectionAwareInterface;

interface RouterInterface extends InjectionAwareInterface
{
    public function toArray(): array;
    
    /** @psalm-suppress MissingReturnType */
    public function setDefaults(array $defaults);
}
