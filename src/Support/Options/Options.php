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

/**
 * The Options trait provides a set of methods for managing options in a class.
 */
trait Options
{
    /**
     * @var mixed[] $defaultOptions Default options for something.
     */
    protected array $defaultOptions = [];
    
    /**
     * @var mixed[] $options Options for something.
     */
    protected array $options = [];
    
    /**
     * Constructs a new instance of the class.
     *
     * @param mixed[]|null $options An optional array of options to initialize the instance with. Default is null.
     */
    public function __construct(?array $options = null)
    {
        $this->initializeOptions($options);
    }
    
    /**
     * Initializes the options for the object.
     *
     * @param mixed[]|null $options The options to be initialized. If null, an empty array will be used.
     *
     * @return void
     */
    public function initializeOptions(?array $options = null): void
    {
        $options ??= [];
        $this->defaultOptions = $options;
        $this->setOptions($options);
        $this->initialize();
    }
    
    /**
     * Initializes the object.
     *
     * This method is responsible for performing any necessary setup or initialization tasks for the object.
     * It does not accept any parameters and does not return a value.
     *
     * @return void
     */
    public function initialize(): void
    {
    }
    
    /**
     * Sets the options for the object.
     *
     * @param mixed[] $options The array of options to be set.
     * @param bool $merge Whether to merge the existing options with the new options. Defaults to false.
     *
     * @return void
     */
    public function setOptions(array $options, bool $merge = false): void
    {
        $this->options = $merge ? array_merge($this->options, $options) : $options;
    }
    
    /**
     * Retrieves all options.
     *
     * @return mixed[] An array containing all the options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }
    
    /**
     * Sets the value of the option specified by the given key.
     *
     * @param string $key The key of the option.
     * @param mixed $value The value to be set for the option.
     * @param bool $merge Whether to merge the new value with an existing value if the option already exists.
     *
     * @return void
     */
    public function setOption(string $key, mixed $value = null, bool $merge = false): void
    {
        if ($merge) {
            $this->options = array_merge($this->options, [$key => $value]);
        } else {
            $this->options[$key] = $value;
        }
    }
    
    /**
     * Retrieves the value of the option specified by the given key.
     *
     * @param string $key The key of the option.
     * @param mixed $default The default value to be returned if the option does not exist.
     * 
     * @return mixed The value of the option specified by the key, or the default value if the option does not exist.
     */
    public function getOption(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }
    
    /**
     * Checks if the option specified by the given key exists.
     *
     * @param string $key The key of the option.
     *
     * @return bool Returns true if the option exists, false otherwise.
     */
    public function hasOption(string $key): bool
    {
        return isset($this->options[$key]);
    }
    
    /**
     * Remove an option by key
     *
     * Removes the option with the given key from the options array.
     *
     * @param string $key The key of the option to be removed
     * @return void
     */
    public function removeOption(string $key): void
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }
    }
    
    /**
     * Reset all options to their default values
     * - Uses the defaultOptions property to set the options
     * 
     * @return void
     */
    public function resetOptions(): void
    {
        $this->setOptions($this->defaultOptions);
    }
    
    /**
     * Clear all options
     *
     * This method clears all the options stored in the class.
     * After calling this method, the options array will be empty.
     *
     * @return void
     */
    public function clearOptions(): void
    {
        $this->options = [];
    }
}
