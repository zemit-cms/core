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

interface OptionsInterface
{
    public function __construct(array $options = null);
    
    public function initializeOptions(array $options = null): void;
    
    public function initialize(): void;
    
    public function setOptions(array $options): void;
    
    public function getOptions(): array;
    
    public function setOption(string $key, mixed $value = null): void;
    
    public function getOption(string $key, mixed $default = null): mixed;
    
    public function removeOption(string $key): void;
    
    public function resetOptions(): void;
    
    public function clearOptions(): void;
}
