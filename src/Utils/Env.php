<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Utils;

use Dotenv\Loader as DotenvLoader;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * Class Env
 * Allow to access environment variable easily
 * Ex. (SET): $this->SET_APPLICATION_ENV('production');
 * Ex. (SET): self::SET_APPLICATION_ENV('production');
 * Ex. (GET): $this->GET_APPLICATION_ENV('development');
 * Ex. (GET): self::GET_APPLICATION_ENV('development');
 * @package Zemit\Utils
 */
class Env
{
    /**
     * Dotenv loader to manage the environment varialbe
     * @var DotenvLoader
     */
    public static $dotenv;
    
    /**
     * Get the dotenv loader
     * @return DotenvLoader
     */
    public static function getDotenv($filePath = null) {
        return isset(self::$dotenv)? self::$dotenv : self::$dotenv = new DotenvLoader($filePath);
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
        $ret = null;
        $getSet = 'set';
        if (strpos($name, 'SET_') === 0) {
            $name = substr($name, 0, 4);
        }
        else if (strpos($name, 'set') === 0) {
            $name = substr($name, 0, 3);
        }
        else if (strpos($name, 'GET_') === 0) {
            $getSet = 'get';
            $name = substr($name, 0, 4);
        }
        else if (strpos($name, 'get') === 0) {
            $getSet = 'get';
            $name = substr($name, 0, 3);
        }
        return self::$getSet($name, array_pop($arguments));
    }
    
    /**
     * Gets the value of an environment variable. Passe the $default for fallback value.
     * @param string $key Key to get
     * @param mixed $default Value to fallback if the key can't be found
     * @return mixed Return the environment variable value or the default value
     */
    public static function get($key, $default = null)
    {
        $ret = self::getDotenv()->getEnvironmentVariable($key);
        
        if ($ret === null) {
            $ret = ($default instanceof Closure) ? $default() : $default;
        }
        
        if (is_string($ret)) {
            switch(strtolower($ret)) {
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
     * @param $key string Key to set
     * @param $value mixed Value to set
     */
    public static function set($key, $value)
    {
        self::getDotenv()->setEnvironmentVariable($key, $value);
    }
    
    /**
     * Return the environnement variable
     * @param $name Env key to fetch
     * @return mixed Env value
     */
    public function __get($name)
    {
        return self::get($name);
    }
    
    /**
     * Set the environnement variable
     * @param $name string Env key to set
     * @param $value mixed Value to set
     * @return mixed Env value
     */
    public function __set(string $name, $value)
    {
        return self::set($name, $value);
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