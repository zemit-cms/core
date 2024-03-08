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

use Phalcon\Config\ConfigInterface as PhalconConfigInterface;
use Zemit\Mvc\Model;

class Config extends \Phalcon\Config\Config implements ConfigInterface
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
        
        if ($ret instanceof PhalconConfigInterface) {
            return $ret->toArray();
        }
        
        return (array)$ret;
    }
    
    public function merge($toMerge, bool $append = false): PhalconConfigInterface
    {
        if (!$append) {
            return parent::merge($toMerge);
        }
        
        $source = $this->toArray();
        $this->clear();
        $toMerge = $toMerge instanceof PhalconConfigInterface ? $toMerge->toArray() : $toMerge;
        
        if (!is_array($toMerge)) {
            throw new \Exception('Invalid data type for merge.');
        }
        
        $result = $this->internalMergeAppend($source, $toMerge);
        $this->init($result);
        return $this;
    }
    
    final protected function internalMergeAppend(array $source, array $target): array
    {
        foreach ($target as $key => $value) {
            if (is_array($value) && isset($source[$key]) && is_array($source[$key])) {
                $source[$key] = $this->internalMergeAppend($source[$key], $value);
            }
            elseif (is_int($key)) {
                $source[] = $value;
            }
            else {
                $source[$key] = $value;
            }
        }
        
        return $source;
    }
    
    /**
     * Return a new model instance from class name
     * @todo use DI instead
     */
    public function getModelInstance(string $class): Model
    {
        $modelClass = $this->getModelClass($class);
        return new $modelClass();
    }
    
    /**
     * Return the mapped model class name from $this->models->$class
     * @todo use DI instead
     */
    public function getModelClass(string $class): string
    {
        return $this->get('models')->get($class) ?: $class;
    }
    
    /**
     * Map a new model class
     * @todo use DI instead
     */
    public function setModelClass(string $class, string $expected): void
    {
        $this->get('models')->set($class, $expected);
    }
    
    /**
     * Map a new model class
     * @todo use DI instead
     */
    public function resetModelClass(string $class): void
    {
        $this->get('models')->set($class, $class);
    }
}
