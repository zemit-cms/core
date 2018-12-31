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
use Zemit\Exception;
use Zemit\Utils\Slug;

/**
 * Zemit\Events\EventManagerAwareTrait
 *
 * Trait for event processing
 *
 * @package Zemit\Events
 */
trait EventsAwareTrait
{
    /**
     * @var Manager
     */
    protected $eventsManager = null;
    
    /**
     * set event manager
     *
     * @param Manager $eventsManager
     */
    public function setEventsManager(Manager $manager)
    {
        $this->eventsManager = $manager;
    }
    
    /**
     * return event manager
     *
     * @return Manager | null
     */
    public function getEventsManager()
    {
        if (!empty($this->eventsManager)) {
            $manager = $this->eventsManager;
        } elseif (Di::getDefault()->has('eventsManager')) {
            $manager = Di::getDefault()->get('eventsManager');
        }
        if (isset($manager) && $manager instanceof Manager) {
            return $manager;
        }
        return null;
    }
    
    /**
     * Event slug to use as a component
     * my-component:beforeSomeTask
     * my-component:afterSomeTask
     *
     * @var null|string
     */
    public static $_eventsSlug = null;
    
    /**
     * Return the event component slug
     *
     * @return null|string Component slug
     * @throws \Zemit\Exception
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
    
    public function setHolderClass(&$holder, $class, $callable)
    {
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
     * Checking if event manager is defined - fire event
     *
     * @param $task
     * @param null $data
     * @param bool $cancelable
     *
     * @throws Exception
     */
    public function fire($task, $data = null, $cancelable = false)
    {
        if ($manager = $this->getEventsManager()) {
            $manager->fire($this->getEventsSlug() . ':' . $task, $this, $data, $cancelable);
        }
    }
    
    /**
     * @param $holder
     * @param null $class
     * @param array $params
     * @param null $callback
     *
     * @throws Exception
     */
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
                throw new Exception('Class "' . $class . '" not found');
            } else {
                throw new Exception('Unknown type "' . $class . '" for "$class"');
            }
        } else if (is_string($holder)) {
            if (class_exists($holder)) {
                $holder = new $holder(...$params);
            } else if (is_callable($holder)) {
                $holder = $holder(...$params);
            } else {
                throw new Exception('Class "' . $class . '" not found');
            }
        }
        if (isset($callback) && is_callable($callback)) {
            $callback($this);
        }
        $this->fire('after' . $event, $holder);
    }
}