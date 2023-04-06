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

trait Options
{
    protected array $defaultOptions = [];
    protected array $options = [];
    
    public function __construct(array $options = null)
    {
        $this->initializeOptions($options);
    }

    /**
     * Initialize Options
     */
    public function initializeOptions(?array $options = null): void
    {
        $options ??= [];
        $this->defaultOptions = $options;
        $this->setOptions($options);
        $this->initialize();
    }

    /**
     * Classes can use this as a constructor after options are initialized
     */
    public function initialize(): void
    {
    }

    /**
     * Set options array
     */
    public function setOptions(array $options, bool $merge = false): void
    {
        $this->options = $merge? array_merge($this->options, $options) : $options;
    }

    /**
     * Get options array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set an option value
     * @param string $key
     * @param ?mixed $value
     * @return void
     */
    public function setOption(string $key, $value = null): void
    {
        $this->options[$key] = $value;
    }

    /**
     * Retrieve an option value by key
     * - Return default value if null
     * @param string $key The key to retrieve
     * @param mixed $default Returned if the option couldn't be found
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Remove an option by key
     */
    public function removeOption(string $key): void
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }
    }

    /**
     * Reset options to default values
     */
    public function resetOptions(): void
    {
        $this->setOptions($this->defaultOptions);
    }

    /**
     * Clear options by forcing an empty array
     */
    public function clearOptions(): void
    {
        $this->options = [];
    }
}
