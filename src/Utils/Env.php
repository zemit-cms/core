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

use Dotenv\Dotenv;

/**
 * Class Env
 * Allow to access environment variable easily
 *
 * Example usage:
 * ```php
 * $this->SET_APPLICATION_ENV('production'); // SET APPLICATION_ENV to 'production'
 * self::SET_APPLICATION_ENV('production'); // SET APPLICATION_ENV to 'production'
 * $this->GET_APPLICATION_ENV('default'); // GET APPLICATION_ENV value or 'default'
 * self::GET_APPLICATION_ENV('default'); // GET APPLICATION_ENV value or 'default'
 * ```
 *
 * @todo fix dotenv mandatory file
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Utils
 */
class Env
{
    public static Dotenv $dotenv;
    public static array $vars;
    
    public static function getDotenv(array $filePath = null): Dotenv
    {
        $filePath ??= self::getCurrentPath();
        $envFilePath = $filePath . '/.env';
        
        if (is_readable($envFilePath)) {
            self::$dotenv ??= Dotenv::createMutable($filePath);
            self::$vars ??= self::$dotenv->load();
        }
    
        self::$vars ??= getenv();
        return self::$dotenv;
    }
    
    /**
     * @return false|mixed|string
     */
    public static function getCurrentPath() {
        
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            return dirname($_SERVER['DOCUMENT_ROOT']);
        }
        
        if (defined('ENV_PATH')) {
            return constant('ENV_PATH');
        }
        
        return getcwd();
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
        } elseif (strpos($name, 'set') === 0) {
            $name = substr($name, 0, 3);
        } elseif (strpos($name, 'GET_') === 0) {
            $getSet = 'get';
            $name = substr($name, 0, 4);
        } elseif (strpos($name, 'get') === 0) {
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
        $ret ??= is_callable($default)? $default() : $default;
        
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
