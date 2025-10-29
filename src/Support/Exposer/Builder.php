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

namespace Zemit\Support\Exposer;

class Builder implements BuilderInterface
{
    private mixed $value = null;
    
    private mixed $parent = null;
    
    private ?array $columns = null;
    
    private ?string $field = null;
    
    private ?string $key = null;
    
    private ?string $contextKey = null;
    
    private bool $expose = true;
    
    private bool $protected = false;
    
    #[\Override]
    public function getValue(): mixed
    {
        return $this->value;
    }
    
    #[\Override]
    public function setValue(mixed $value = null): void
    {
        $this->value = $value;
    }
    
    #[\Override]
    public function getParent(): mixed
    {
        return $this->parent;
    }
    
    #[\Override]
    public function setParent(mixed $parent = null): void
    {
        $this->parent = $parent;
    }
    
    #[\Override]
    public function getKey(): ?string
    {
        return $this->key;
    }
    
    #[\Override]
    public function setKey(?string $key = null): void
    {
        $this->key = self::processKey($key);
    }
    
    #[\Override]
    public function getContextKey(): ?string
    {
        return $this->contextKey;
    }
    
    #[\Override]
    public function setContextKey(?string $contextKey = null): void
    {
        $this->contextKey = self::processKey($contextKey);
    }
    
    #[\Override]
    public function getField(): ?string
    {
        return $this->field;
    }
    
    #[\Override]
    public function setField(?string $field = null): void
    {
        $this->field = $field;
    }
    
    #[\Override]
    public function getColumns(): ?array
    {
        return $this->columns;
    }
    
    #[\Override]
    public function setColumns(?array $columns = null): void
    {
        $this->columns = $columns;
    }
    
    #[\Override]
    public function getExpose(): bool
    {
        return $this->expose;
    }
    
    #[\Override]
    public function setExpose(bool $expose): void
    {
        $this->expose = $expose;
    }
    
    #[\Override]
    public function getProtected(): bool
    {
        return $this->protected;
    }
    
    #[\Override]
    public function setProtected(bool $protected): void
    {
        $this->protected = $protected;
    }
    
    /**
     * Retrieves the full key constructed from the context and the key.
     *
     * The full key is determined based on the following conditions:
     * - If the key is empty, the context is returned.
     * - If the context is empty, the key is returned.
     * - If both are present, the result is a concatenation of context and key separated by a dot.
     *
     * @return string|null The constructed full key or null if both key and context are null.
     */
    #[\Override]
    public function getFullKey(): ?string
    {
        $key = $this->getKey();
        $context = $this->getContextKey();
        
        // If $key is empty, just return the context
        if (empty($key)) {
            return $context;
        }
        
        // If $key is not empty but $context is empty, return just the key
        if (empty($context)) {
            return $key;
        }
        
        // Both present: "context.key"
        return $context . '.' . $key;
    }
    
    /**
     * Processes the given key by normalizing its format.
     *
     * @param string|null $key The input key to be processed. It can be null, an empty string, or a string.
     * @return string|null Returns the processed key in a normalized format or an empty string if the input is null, empty, or a valid integer string.
     */
    public static function processKey(?string $key = null): ?string
    {
        if ($key === null || $key === '' || filter_var($key, FILTER_VALIDATE_INT)) {
            return '';
        }
        
        $key = preg_replace('/\s+/', '.', $key) ?? '';
        $key = preg_replace('/\.+/', '.', $key) ?? '';
        return trim(mb_strtolower($key), '.');
    }
}
