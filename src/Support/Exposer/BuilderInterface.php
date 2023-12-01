<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\Exposer;

interface BuilderInterface
{
    public function getValue();
    
    public function setValue($value = null): void;
    
    
    public function getParent();
    
    public function setParent($parent = null): void;
    
    
    public function getColumns(): ?array;
    
    public function setColumns(?array $columns = null): void;
    
    
    public function getField(): ?string;
    
    public function setField(?string $field = null): void;
    
    
    public function getKey(): ?string;
    
    public function setKey(?string $key = null): void;
    
    
    public function getContextKey(): ?string;
    
    public function setContextKey(?string $contextKey = null): void;
    
    
    public function getExpose(): bool;
    
    public function setExpose(bool $expose): void;
    
    
    public function getProtected(): bool;
    
    public function setProtected(bool $protected): void;
    
    
    public function getFullKey(): ?string;
}
