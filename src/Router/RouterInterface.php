<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Router;

use Phalcon\Di\InjectionAwareInterface;

interface RouterInterface extends InjectionAwareInterface
{
    public function toArray(): array;
    
    public function setDefaults(array $defaults);
}
