<?php

namespace Zemit\Core\Events;

use Phalcon\Traits\EventManagerAwareTrait;
use Phalcon\Utils\Slug;

/**
 * Phalcon\Traits\EventManagerAwareTrait
 *
 * Trait for event processing
 *
 * @package Phalcon\Traits
 */
trait EventsAwareTrait
{
    use EventManagerAwareTrait {
        fire as protected fireSource;
    }
    
    /**
     * Event slug to use as a component
     * my-component:afterSomeTask
     *
     * @var null|string
     */
    public static $_eventsSlug = null;
    
    /**
     * Return the event component slug
     *
     * @return null|string Component slug
     * @throws \Phalcon\Exception
     */
    public static function getEventsSlug()
    {
        return
            self::$_eventsSlug ??
            self::$_eventsSlug =
                Slug::generate(
                    basename(
                        str_replace('\\', '/', __CLASS__)
                    )
                );
    }
    
    /**
     * Set the event component slug
     *
     * @param $eventSlug
     */
    public static function setEventSlug($eventSlug)
    {
        self::$_eventsSlug = $eventSlug;
    }
    
    public function setHolderClass(&$holder, $class, $callable) {
        $this->fire('before' . $class, $holder);
        if (!isset($holder)) {
            $holder = new $class;
        } else if (is_string($holder)) {
            if (is_callable($holder)) {
                $holder = new $holder;
            } else {
//                throw new \Exception('Class "' . $class . '" not found');
            }
        }
        if (isset($callable) && is_callable($callable)) {
            $callable($this);
        }
        $this->fire('after' . $class, $holder);
    }
    
    /**
     * @inheritdoc
     *
     * @param $task
     * @param null $data
     * @param bool $cancelable
     *
     */
    public function fire($task, $data = null, $cancelable = false)
    {
        $this->fireSource($this->getEventsSlug() . ':' . $task, $this, $data, $cancelable);
    }
    
    public function fireSet(&$holder, $class = null, $params = [], $callback = null)
    {
        $event = basename(str_replace('\\', '//', $class));
        $this->fire('before' . $event, $holder);
        if (!isset($holder)) {
            if (class_exists($class)) {
                $holder = new $class(...$params);
            } else if (is_callable($class)) {
                $holder = $class(...$params);
            } else if (is_object($class)) {
                $holder = $class;
            } else if (is_string($class)) {
//                throw new \Exception('Class "' . $class . '" not found');
            } else {
//                throw new \Exception('Unknown type "' . $class . '" for "$class"');
            }
        } else if (is_string($holder)) {
            if (class_exists($holder)) {
                $holder = new $holder(...$params);
            } else if (is_callable($holder)) {
                $holder = $holder(...$params);
            } else {
//                throw new \Exception('Class "' . $class . '" not found');
            }
        }
        if (isset($callback) && is_callable($callback)) {
            $callback($this);
        }
        $this->fire('after' . $event, $holder);
    }
}