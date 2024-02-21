<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Events;

use Phalcon\Di\Di;
use Phalcon\Events\ManagerInterface;
use Zemit\Utils\Slug;

/**
 * The EventsAwareTrait provides methods for managing events within a class.
 */
trait EventsAwareTrait
{
    /**
     * Event prefix to use as a component
     * my-component:beforeSomeTask
     * my-component:afterSomeTask
     */
    public static ?string $eventsPrefix;
    
    /**
     * The event manager responsible for handling and triggering events.
     */
    protected ?ManagerInterface $eventsManager;
    
    /**
     * Set the events manager
     */
    public function setEventsManager(ManagerInterface $manager): void
    {
        $this->eventsManager = $manager;
    }
    
    /**
     * Get the events manager.
     */
    public function getEventsManager(): ?ManagerInterface
    {
        $this->eventsManager ??= Di::getDefault()->get('eventsManager');
        return $this->eventsManager;
    }
    
    
    /**
     * Get the event component prefix
     *
     * @return string|null The event component prefix, or null if not set
     */
    public static function getEventsPrefix(): ?string
    {
        self::$eventsPrefix ??= Slug::generate(basename(str_replace('\\', '/', __CLASS__)));
        return self::$eventsPrefix;
    }
    
    /**
     * Sets the events prefix.
     *
     * @param string|null $eventsPrefix The prefix to be used for events. Pass null to remove the prefix.
     *
     * @return void
     */
    public static function setEventsPrefix(?string $eventsPrefix): void
    {
        self::$eventsPrefix = $eventsPrefix;
    }
    
    /**
     * Fire an event.
     *
     * @param string $task The task to execute.
     * @param mixed|null $data The optional data to pass to the event.
     * @param bool $cancelable Whether the event is cancelable or not. Defaults to false.
     * 
     * @return mixed
     */
    public function fire(string $task, mixed $data = null, bool $cancelable = false): mixed
    {
        $eventType = $this->getEventsPrefix() . ':' . $task;
        return $this->getEventsManager()->fire($eventType, $this, $data, $cancelable);
    }
    
    /**
     * Fire the set event
     *
     * @param mixed &$holder The referenced variable to be set
     * @param string|null $class The class name or object to set if $holder is not set
     * @param array $params The parameters to be passed to the class constructor or callable
     * @param callable|null $callback The callback to be executed after setting the value
     * 
     * @return mixed
     * @throws \Exception if the class is not found or an unknown type is specified for $class
     */
    public function fireSet(mixed &$holder, string $class = null, array $params = [], callable $callback = null): mixed
    {
        // prepare event name
        $event = basename(str_replace('\\', '//', $class));
        
        // fire before event with the holder
        $this->fire('before' . $event, func_get_args());
        
        // holder not set, apply class to it
        if (!isset($holder)) {
            
            // can be a class path
            if (class_exists($class)) {
                $holder = new $class(...$params);
            }
            
            // can be a callable
            elseif (is_callable($class)) {
                $holder = $class(...$params);
            }
            
            // can be the object
            elseif (is_object($class)) {
                $holder = $class;
            }
            
            // class not found
            elseif (is_string($class)) {
                throw new \Exception('Class "' . $class . '" not found');
            }
            
            // other error
            else {
                throw new \Exception('Unknown type "' . $class . '" for "$class"');
            }
        }
        
        elseif (is_string($holder)) {
            
            // can be a class path
            if (class_exists($holder)) {
                $holder = new $holder(...$params);
            }
            
            // class not founmd
            else {
                throw new \Exception('Class "' . $class . '" not found');
            }
        }
        
        // run the callback if isset
        if (isset($callback) && is_callable($callback)) {
            $callback($this);
        }
        
        // fire after event
        $this->fire('after' . $event, func_get_args());
        
        // return the holder
        return $holder;
    }
}
