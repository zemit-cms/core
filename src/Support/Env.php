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
 * Allow to access environment variable easily
 *
 * Example usage:
 * ```php
 * $this->SET_APPLICATION_ENV('production'); // SET APPLICATION_ENV to 'production'
 * self::SET_APPLICATION_ENV('production'); // SET APPLICATION_ENV to 'production'
 * $this->GET_APPLICATION_ENV('default'); // GET APPLICATION_ENV value or 'default'
 * self::GET_APPLICATION_ENV('default'); // GET APPLICATION_ENV value or 'default'
 * ```
 * @todo fix dotenv mandatory file
 */
class Env
{
    public static bool $initialized = false;
    
    public static Dotenv $dotenv;
    public static array $vars = [];
    
    public static ?array $paths = null;
    public static array $names = ['.env'];
    public static string $type = 'mutable';
    public static bool $shortCircuit = true;
    public static ?string $fileEncoding = null;
    
    public function __construct()
    {
        self::initialize();
    }
    
    /**
     * @param array|null $paths
     * @param array|null $names
     * @param bool|null $shortCircuit
     * @param string|null $fileEncoding
     * @param string|null $type
     * @return Dotenv
     */
    public static function initialize(
        ?array $paths = null,
        ?array $names = null,
        ?bool $shortCircuit = null,
        ?string $fileEncoding = null,
        ?string $type = null
    ): Dotenv {
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
     * Get .env directories
     * @return array
     */
    public static function getPaths()
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
     * Set .env directories
     * @param $paths
     * @return void
     */
    public static function setPaths(?array $paths = null): void
    {
        self::$paths = $paths;
    }
    
    /**
     * Get .env file names
     * @return string|string[]
     */
    public static function getNames()
    {
        return self::$names;
    }
    
    /**
     * Set .env file names
     * @param $names
     * @return void
     */
    public static function setNames(array $names): void
    {
        self::$names = $names;
    }
    
    /**
     * Get Dotenv type
     * @return string
     */
    public static function getType()
    {
        return ucfirst(Helper::camelize(strtolower(self::$type ?? 'mutable')));
    }
    
    /**
     * Sets the Dotenv type ('mutable', 'immutable', 'unsafe-mutable', 'unsafe-immutable')
     *
     * @param string|null $type The type to set. If null, the type will default to 'mutable'.
     * @return void
     */
    public static function setType(?string $type = null): void
    {
        $domain = ['mutable', 'immutable', 'unsafe-mutable', 'unsafe-immutable'];
        self::$type = isset($type) && !in_array(strtolower($type), $domain, true) ? strtolower($type) : 'mutable';
    }
    
    /**
     * @return boolean
     */
    public static function getShortCircuit(): bool
    {
        return self::$shortCircuit;
    }
    
    /**
     * @param bool $shortCircuit
     * @return void
     */
    public static function setShortCircuit(bool $shortCircuit = true): void
    {
        self::$shortCircuit = (bool)$shortCircuit;
    }
    
    /**
     * @return ?string
     */
    public static function getFileEncoding(): ?string
    {
        return self::$fileEncoding;
    }
    
    /**
     * @param ?string $fileEncoding
     * @return void
     */
    public static function setFileEncoding(?string $fileEncoding = null): void
    {
        self::$fileEncoding = $fileEncoding;
    }
    
    
    /**
     * @return Dotenv
     */
    public static function getDotenv()
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
    public static function call($name, $arguments)
    {
        $getSet = 'set';
        
        if (strpos($name, 'SET_') === 0) {
            $name = substr($name, 0, 4);
        }
        
        elseif (strpos($name, 'set') === 0) {
            $name = substr($name, 0, 3);
        }
        
        elseif (strpos($name, 'GET_') === 0) {
            $getSet = 'get';
            $name = substr($name, 0, 4);
        }
        
        elseif (strpos($name, 'get') === 0) {
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
    public static function get(string $key, $default = null)
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
    public static function set(string $key, $value)
    {
        self::$vars[$key] = $value;
        $_ENV[$key] = $value;
    }
    
    /**
     * Return the environment variable
     * @param string $name Env key to fetch
     * @return mixed Env value
     */
    public function __get(string $name)
    {
        return self::get($name);
    }
    
    /**
     * Set the environment variable
     * @param string $name Env key to set
     * @param mixed $value Value to set
     */
    public function __set(string $name, $value)
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
    public static function __callStatic(string $name, array $arguments)
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
    public function __call(string $name, array $arguments)
    {
        return self::call($name, $arguments);
    }
}
