<?php

namespace Zemit\Support\Options;

interface ManagerInterface
{
    public function get(string $key, $default = null);
    
    public function set(string $key, $value = null): void;
    
    public function remove(string $key): void;
    
    public function reset(): void;
    
    public function clear(): void;
}
