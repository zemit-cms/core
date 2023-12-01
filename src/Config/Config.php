<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Config;

class Config extends \Phalcon\Config implements ConfigInterface
{
    /**
     * Return the element as an array
     */
    public function pathToArray(string $path, ?array $defaultValue = null, ?string $delimiter = null): ?array
    {
        $ret = $this->path($path, $defaultValue, $delimiter);
        
        if (is_null($ret)) {
            return null;
        }
        
        if ($ret instanceof \Phalcon\Config) {
            return $ret->toArray();
        }
        
        return (array)$ret;
    }
    
    /**
     * Return the mapped model class name from $this->models->$class
     */
    public function getModelClass(string $class): string
    {
        return $this->get('models')->get($class) ?: $class;
    }
    
    /**
     * Map a new model class
     */
    public function setModelClass(string $class, string $expected): void
    {
        $this->get('models')->set($class, $expected);
    }
    
    /**
     * Map a new model class
     */
    public function resetModelClass(string $class): void
    {
        $this->get('models')->set($class, $class);
    }
}
