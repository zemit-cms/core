<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

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
     * @param array|null $options
     * @return void
     */
    public function initializeOptions(array $options = null) {
        $options ??= [];
        $this->defaultOptions = $options;
        $this->setOptions($options);
        $this->initialize();
    }
    
    /**
     * Classes can use this as a constructor after options are initialized
     * @return void
     */
    public function initialize()
    {
    
    }
    
    /**
     * Set options array
     * @param array $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
    
    /**
     * Get options array
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
    
    /**
     * Set an option value
     * @param string $key
     * @param mixed|null $value
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
     * @param mixed|null $default Returned if the option couldn't be found
     * @return mixed|null
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }
    
    /**
     * Remove an option by key
     * @param string $key
     * @return void
     */
    public function removeOption(string $key): void
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }
    }
    
    /**
     * Reset options to default values
     * @return void
     */
    public function resetOptions(): void
    {
        $this->setOptions($this->defaultOptions);
    }
    
    /**
     * Clear options by forcing an empty array
     * @return void
     */
    public function clearOptions(): void
    {
        $this->options = [];
    }
}
