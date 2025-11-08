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

namespace PhalconKit\Support\Options;

interface ManagerInterface
{
    public function get(string $key, mixed $default = null): mixed;
    
    public function set(string $key, mixed $value = null): void;
    
    public function remove(string $key): void;
    
    public function reset(): void;
    
    public function clear(): void;
}
