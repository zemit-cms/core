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

use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Events\ManagerInterface;
use Zemit\Exception;
use Zemit\Utils\Slug;

/**
 * Trait EventsAwareTrait
 *
 *
 *
 * @package Zemit\Events
 */
trait EventsAwareTrait
{
    protected ?ManagerInterface $eventsManager;
    
    public function setEventsManager(ManagerInterface $manager): void
    {
        $this->eventsManager = $manager;
    }
    
    public function getEventsManager(): ?ManagerInterface
    {
        $this->eventsManager ??= Di::getDefault()->get('eventsManager');
        return $this->eventsManager;
    }
    
    /**
     * Event prefix to use as a component
     * my-component:beforeSomeTask
     * my-component:afterSomeTask
     */
    public static ?string $eventsPrefix;
    
    /**
     * Return the event component prefix
     */
    public static function getEventsPrefix(): ?string
    {
        self::$eventsPrefix ??= Slug::generate(basename(str_replace('\\', '/', __CLASS__)));
        return self::$eventsPrefix;
    }
    
    /**
     * Set the event component prefix
     */
    public static function setEventsPrefix(?string $eventsPrefix): void
    {
        self::$eventsPrefix = $eventsPrefix;
    }
    
    /**
     * Checking if event manager is defined - fire event
     *
     * @param mixed $task
     * @param mixed $data
     * @param bool $cancelable
     *
     * @return mixed
     */
    public function fire($task, $data = null, bool $cancelable = false)
    {
        $eventType = $this->getEventsPrefix() . ':' . $task;
        return $this->getEventsManager()->fire($eventType, $this, $data, $cancelable);
    }
    
    /**
     * Fire "before" event
     * Run class with parameters
     * Fire "after" event
     * Return the holder
     *
     * @param $holder
     * @param null $class
     * @param array $params
     * @param null $callback
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function fireSet(&$holder, $class = null, array $params = [], $callback = null)
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
