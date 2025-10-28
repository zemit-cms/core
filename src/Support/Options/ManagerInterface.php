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

namespace Zemit\Support\Options;

interface ManagerInterface
{
    public function get(string $key, mixed $default = null): mixed;
    
    public function set(string $key, mixed $value = null): void;
    
    public function remove(string $key): void;
    
    public function reset(): void;
    
    public function clear(): void;
}
