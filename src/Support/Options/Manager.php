<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\Options;

class Manager implements ManagerInterface
{
    use Options;
    
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getOption($key, $default);
    }
    
    public function set(string $key, mixed $value = null): void
    {
        $this->setOption($key, $value);
    }
    
    public function remove(string $key): void
    {
        $this->removeOption($key);
    }
    
    public function reset(): void
    {
        $this->resetOptions();
    }
    
    public function clear(): void
    {
        $this->clearOptions();
    }
}
