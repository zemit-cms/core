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
use Phalcon\Events\Manager;
use Phalcon\Events\ManagerInterface;
use Zemit\Exception;
use Zemit\Utils\Slug;

/**
 * Trait EventsAwareTrait
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
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
     * Set Event Manager Service Provider
     *
     * @param Manager $eventsManager
     */
    public function setEventsManager(ManagerInterface $manager)
    {
        $this->eventsManager = $manager;
    }
    
    /**
     * return event manager
     *
     * @return Manager|null
     */
    public function getEventsManager() : ?ManagerInterface
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
        } else {
            throw new \Exception('Events Manager Service Provider \'eventsManager\' does not exists in DI of \'' . get_class($this) . '\'');
        }
    }
    
    /**
     * Add possibility to parse an holder and run a callback after
     *
     * @param $holder
     * @param null $class
     * @param array $params
     * @param null $callback
     *
     * @return mixed|null
     * @throws Exception
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
        } elseif (is_string($holder)) {
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
