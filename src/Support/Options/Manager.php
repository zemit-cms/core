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

class Manager implements ManagerInterface, OptionsInterface
{
    use Options;
    
    #[\Override]
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getOption($key, $default);
    }
    
    public function has(string $key): bool
    {
        return $this->hasOption($key);
    }
    
    #[\Override]
    public function set(string $key, mixed $value = null): void
    {
        $this->setOption($key, $value);
    }
    
    #[\Override]
    public function remove(string $key): void
    {
        $this->removeOption($key);
    }
    
    #[\Override]
    public function reset(): void
    {
        $this->resetOptions();
    }
    
    #[\Override]
    public function clear(): void
    {
        $this->clearOptions();
    }
}
