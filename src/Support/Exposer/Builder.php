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

class Builder implements BuilderInterface
{
    private mixed $value;
    
    private mixed $parent;
    
    private ?array $columns = null;
    
    private ?string $field = null;
    
    private ?string $key = null;
    
    private ?string $contextKey = null;
    
    private bool $expose = true;
    
    private bool $protected = false;
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue(mixed $value = null): void
    {
        $this->value = $value;
    }
    
    public function getParent(): mixed
    {
        return $this->parent;
    }
    
    public function setParent(mixed $parent = null): void
    {
        $this->parent = $parent;
    }
    
    public function getKey(): ?string
    {
        return $this->key;
    }
    
    public function setKey(?string $key = null): void
    {
        $this->key = self::processKey($key);
    }
    
    public function getContextKey(): ?string
    {
        return $this->contextKey;
    }
    
    public function setContextKey(?string $contextKey = null): void
    {
        $this->contextKey = self::processKey($contextKey);
    }
    
    public function getField(): ?string
    {
        return $this->field;
    }
    
    public function setField(?string $field = null): void
    {
        $this->field = $field;
    }
    
    public function getColumns(): ?array
    {
        return $this->columns;
    }
    
    public function setColumns(?array $columns = null): void
    {
        $this->columns = $columns;
    }
    
    public function getExpose(): bool
    {
        return $this->expose;
    }
    
    public function setExpose(bool $expose): void
    {
        $this->expose = $expose;
    }
    
    public function getProtected(): bool
    {
        return $this->protected;
    }
    
    public function setProtected(bool $protected): void
    {
        $this->protected = $protected;
    }
    
    public function getFullKey(): ?string
    {
        $key = $this->getKey();
        $keyContext = $this->getContextKey();
        return $keyContext . (empty($key) ? null : (empty($keyContext) ? $key : '.' . $key));
    }
    
    public static function processKey(?string $key = null): ?string
    {
        return empty($key) || filter_var($key, FILTER_VALIDATE_INT) ? '' : mb_strtolower(
            trim(
                preg_replace(
                    '/\.+/',
                    '.',
                    preg_replace(
                        '/\s+/',
                        '.',
                        $key
                    )
                ),
                '.'
            )
        );
    }
}
