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

use Dotenv\Dotenv;
use Phalcon\Di\DiInterface;

/**
 * This class provides utilities for managing environment variables and loading .env files.
 * It allows for easy access to environment variables and provides methods for setting and getting values.
 * It also initializes a Dotenv instance and loads .env files based on specified configurations.
 *
 * @package Zemit\Support
 */
class Env
{
    /**
     * Represents the initialization status of the code.
     *
     * This variable is used to keep track of whether the code has been initialized
     * or not.
     *
     * @var bool
     */
    public static bool $initialized = false;
    
    /**
     * Represents the instance of the Dotenv class.
     *
     * The Dotenv class is responsible for loading environment variables from the
     * ".env" file into the application.
     *
     * @var Dotenv
     */
    public static Dotenv $dotenv;
    
    /**
     * Represents an array of variables.
     *
     * The $vars variable is used to store a collection of key-value pairs,
     * where each key represents a variable name and the corresponding value
     * represents the value of that variable.
     *
     * @var array
     */
    public static array $vars = [];
    
    /**
     * Holds the value of the paths.
     *
     * This variable represents the value of the paths and is initially set to null.
     * It can be assigned a different value during the runtime of the program.
     *
     * @var string[]|null
     */
    public static ?array $paths = null;
    
    /**
     * Represents the array of filenames.
     *
     * The $names variable is an array that holds the filenames of the ".env" file(s) to be loaded.
     * This variable is used as an argument in the Dotenv class to specify the filenames to load.
     *
     * @var string[]
     */
    public static array $names = ['.env'];
    
    /**
     * Represents the type of data being declared.
     *
     * The $type variable is a string that indicates the mutability of the data. It can
     * have two possible values: "mutable" or "immutable".
     *
     * @var string
     */
    public static string $type = 'mutable';
    
    /**
     * Represents a boolean flag that enables short-circuiting in the code.
     *
     * When the $shortCircuit variable is set to true, it indicates that the code
     * should perform short-circuit evaluation. Short-circuit evaluation allows
     * skipping the evaluation of subsequent conditions in a logical expression if
     * the final result can be determined early.
     *
     * @var bool
     */
    public static bool $shortCircuit = true;
    
    /**
     * Represents the encoding of the file.
     *
     * The $fileEncoding variable is used to store the encoding of the file that
     * will be processed by the application. It is initially set to null and will be
     * updated with the actual encoding value during the file processing.
     *
     * @var string|null
     */
    public static ?string $fileEncoding = null;
    
    /**
     * Constructs a new instance of the class.
     *
     * Initializes the class by invoking the initialize method.
     *
     * @return void
     */
    public function __construct()
    {
        self::initialize();
    }
    
    /**
     * Initializes the Dotenv instance with the specified configurations
     * and returns the initialized instance.
     *
     * @param array|null $paths The paths to search for dotenv files.
     * @param array|null $names The names of the dotenv files to load.
     * @param bool|null $shortCircuit Whether to stop loading dotenv files after finding the first one.
     * @param string|null $fileEncoding The encoding of the dotenv files.
     * @param string|null $type The type of dotenv files to load.
     * @return Dotenv The initialized Dotenv instance.
     */
    public static function initialize(?array $paths = null, ?array $names = null, ?bool $shortCircuit = null, ?string $fileEncoding = null, ?string $type = null): Dotenv
    {
        if (!self::$initialized) {
            $type ??= self::getType();
            $paths ??= self::getPaths();
            $names ??= self::getNames();
            $shortCircuit ??= self::getShortCircuit();
            $fileEncoding ??= self::getFileEncoding();
            self::$dotenv = Dotenv::{'create' . $type}($paths, $names, $shortCircuit, $fileEncoding);
            self::$vars = self::$dotenv->load();
            self::$initialized = true;
        }
        
        return self::$dotenv;
    }
    
    /**
     * Retrieves an array of paths.
     * If the paths array is not yet created, it will be initialized and returned.
     *
     * @return array The array of paths.
     */
    public static function getPaths(): array
    {
        if (is_null(self::$paths)) {
            self::$paths = [];
            foreach (['ENV_PATH', 'ROOT_PATH', 'APP_PATH'] as $constant) {
                if (defined($constant)) {
                    $path = constant($constant);
                    if (!is_null($path)) {
                        self::$paths [] = $constant === 'APP_PATH' ? dirname($path) : $path;
                        break;
                    }
                }
            }
            if (empty(self::$paths)) {
                self::$paths [] = getcwd();
            }
        }
        return self::$paths;
    }
    
    /**
     * Sets the paths for the application. If no paths are provided,
     * the paths will be set to null.
     *
     * @param array|null $paths The paths to be set for the application.
     *                         If null is provided, the paths will be set to null.
     *                         Default is null.
     *
     * @return void
     */
    public static function setPaths(array $paths = null): void
    {
        self::$paths = $paths;
    }
    
    /**
     * Get .env file names
     * @return string[]
     */
    public static function getNames(): array
    {
        return self::$names;
    }
    
    /**
     * Sets the names array. If the specified array is null, the existing names array will be cleared.
     *
     * @param string[] $names The array of names. If null, the existing names array will be cleared.
     *
     * @return void
     */
    public static function setNames(array $names): void
    {
        self::$names = $names;
    }
    
    /**
     * Retrieves the type of the instance. If the type is not set, it will default to 'mutable'.
     * The type is then transformed into a camel case string and the first letter is capitalized.
     *
     * @return string The type of the instance.
     */
    public static function getType(): string
    {
        return ucfirst(Helper::camelize(strtolower(self::$type ?? 'mutable')));
    }
    
    /**
     * Sets the type of the object. If the type is not provided or is not one of the allowed types,
     * the type will be set to 'mutable' by default.
     *
     * @param string|null $type The type of the object. Available types: 'mutable', 'immutable', 'unsafe-mutable', 'unsafe-immutable'.
     * @return void
     */
    public static function setType(?string $type = null): void
    {
        $domain = ['mutable', 'immutable', 'unsafe-mutable', 'unsafe-immutable'];
        self::$type = isset($type) && !in_array(strtolower($type), $domain, true) ? strtolower($type) : 'mutable';
    }
    
    /**
     * Retrieves the short circuit value. If the short circuit value is not yet set,
     * it will return the default value.
     *
     * @return bool The short circuit value.
     */
    public static function getShortCircuit(): bool
    {
        return self::$shortCircuit;
    }
    
    /**
     * Sets the value of the shortCircuit property.
     *
     * @param bool $shortCircuit The new value for the shortCircuit property.
     * @return void
     */
    public static function setShortCircuit(bool $shortCircuit = true): void
    {
        self::$shortCircuit = $shortCircuit;
    }
    
    /**
     * Retrieves the file encoding. If the encoding is not yet set, it will return null.
     *
     * @return ?string The file encoding.
     */
    public static function getFileEncoding(): ?string
    {
        return self::$fileEncoding;
    }
    
    /**
     * Sets the file encoding for the env file. If no file encoding is specified,
     * the default encoding will be used.
     *
     * @param string|null $fileEncoding The file encoding to be set. Defaults to null.
     * @return void
     */
    public static function setFileEncoding(?string $fileEncoding = null): void
    {
        self::$fileEncoding = $fileEncoding;
    }
    
    /**
     * Retrieves the Dotenv instance. If the instance is not yet created,
     * it will be initialized and returned.
     *
     * @return Dotenv The Dotenv instance.
     */
    public static function getDotenv(): Dotenv
    {
        return self::$dotenv ?? self::initialize();
    }
    
    /**
     * Get or set the environment variable
     * Ex. (SET): $this->SET_APPLICATION_ENV('production');
     * Ex. (SET): self::SET_APPLICATION_ENV('production');
     * Ex. (SET): Env::SET_APPLICATION_ENV('production');
     * Ex. (GET): $this->GET_APPLICATION_ENV('development');
     * Ex. (GET): self::GET_APPLICATION_ENV('development');
     * Ex. (GET): Env::GET_APPLICATION_ENV('development');
     * @param string $name key to get/set
     * @param mixed $arguments Default fallback value for get, or value to set for set
     * @return mixed Return void for set, and return the environment variable value, or default value for get
     */
    public static function call(string $name, mixed $arguments): mixed
    {
        $getSet = 'set';
        
        if (str_starts_with($name, 'SET_')) {
            $name = substr($name, 0, 4);
        }
        
        elseif (str_starts_with($name, 'set')) {
            $name = substr($name, 0, 3);
        }
        
        elseif (str_starts_with($name, 'GET_')) {
            $getSet = 'get';
            $name = substr($name, 0, 4);
        }
        
        elseif (str_starts_with($name, 'get')) {
            $getSet = 'get';
            $name = substr($name, 0, 3);
        }
        
        return self::$getSet($name, array_pop($arguments));
    }
    
    /**
     * Gets the value of an environment variable. Pass the $default for fallback value.
     * @param string $key Key to get
     * @param mixed $default Value to fallback if the key can't be found
     * @return mixed Return the environment variable value or the default value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::getDotenv();
        
        $ret = self::$vars[$key] ?? null;
        $ret ??= !is_string($default) && is_callable($default)? $default() : $default;
        
        if (is_string($ret)) {
            switch (strtolower($ret)) {
                case 'true':
                    $ret = true;
                    break;
                    
                case 'false':
                    $ret = false;
                    break;
                    
                case 'empty':
                    $ret = '';
                    break;
                    
                case 'null':
                    $ret = null;
                    break;
            }
        }
        
        return $ret;
    }
    
    /**
     * Set an environment variable
     * @param string $key Key to set
     * @param mixed $value Value to set
     */
    public static function set(string $key, mixed $value): void
    {
        self::$vars[$key] = $value;
        $_ENV[$key] = $value;
    }
    
    /**
     * Return the environment variable
     * @param string $name Env key to fetch
     * @return mixed Env value
     */
    public function __get(string $name): mixed
    {
        return self::get($name);
    }
    
    /**
     * Set the environment variable
     * @param string $name Env key to set
     * @param mixed $value Value to set
     */
    public function __set(string $name, mixed $value): void
    {
        self::set($name, $value);
    }
    
    /**
     * Get or set the environment variable
     * Ex. (SET): self::SET_APPLICATION_ENV('production');
     * Ex. (SET): Env::SET_APPLICATION_ENV('production');
     * Ex. (GET): self::GET_APPLICATION_ENV('development');
     * Ex. (GET): Env::GET_APPLICATION_ENV('development');
     * @param $name string Key to get/set
     * @param $arguments array Default fallback value for get, or value to set for set
     * @return mixed Return void for set, and return the environment variable value, or default value for get
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return self::call($name, $arguments);
    }
    
    /**
     * Get or set the environment variable
     * Ex. (SET): $this->SET_APPLICATION_ENV('production');
     * Ex. (GET): $this->GET_APPLICATION_ENV('development');
     * @param $name string Key to get/set
     * @param $arguments array Default fallback value for get, or value to set for set
     * @return mixed Return void for set, and return the environment variable value, or default value for get
     */
    public function __call(string $name, array $arguments): mixed
    {
        return self::call($name, $arguments);
    }
}
