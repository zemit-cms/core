<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Di;

use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;

/**
 * The InjectableTrait trait provides methods for using dependency injection within an object.
 */
trait InjectableTrait
{
    use InjectableProperties;
    
    /**
     * Holds the container instance.
     * @var DiInterface|null
     */
    public ?DiInterface $container;
    
    /**
     * Holds a list of loaded services from the container
     * @var array
     */
    public array $instanceContainer;
    
    /**
     * Returns the Dependency Injection (DI) container used by this object.
     *
     * @return DiInterface The DI container instance.
     */
    public function getDI(): DiInterface
    {
        if (!isset($this->container)) {
            $this->container = Di::getDefault();
        }
        
        return $this->container ?? new DI();
    }
    
    /**
     * Sets the dependency injection container.
     *
     * @param DiInterface $container The dependency injection container.
     *
     * @return void
     */
    public function setDI(DiInterface $container): void
    {
        $this->container = $container;
    }
    
    /**
     * Checks if a property is set.
     *
     * @param string $name The name of the property to check.
     * @return bool True if the property is set, false otherwise.
     */
    public function __isset(string $name): bool
    {
        return isset($this->instanceContainer[$name]) || $this->getDI()->has($name);
    }
    
    /**
     * Magic method __get.
     *
     * Retrieves the value of a non-existent or inaccessible property.
     *
     * @param string $name The name of the property.
     * @return mixed The value of the property if it exists, or null if the property is undefined.
     */
    public function __get(string $name): mixed
    {
        $container = $this->getDI();
        
        if (isset($this->instanceContainer[$name])) {
            return $this->instanceContainer[$name];
        }
        
        if ($name === 'di') {
            $this->instanceContainer[$name] = $container;
            return $container;
        }
        
        if ($name === 'persistent') {
            $persistent = $container->get('sessionBag', [get_class($this)]);
            $this->instanceContainer[$name] = $persistent;
            return $persistent;
        }
        
        if ($container->has($name)) {
            $service = $container->getShared($name);
            $this->instanceContainer[$name] = $service;
            return $service;
        }
        
        trigger_error('Access to undefined property `' . $name . '`');
        return null;
    }
}
