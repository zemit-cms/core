<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

use Phalcon\Di\Injectable;
use Phalcon\Events\Manager;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;

trait Behavior
{
    use AbstractBehavior;
    
    use AbstractInjectable;
    
    public function beforeExecuteRoute(): void
    {
        $this->eventsManager->enablePriorities(true);
        
        // @todo see if we can implement receiving an array of responses globally: V2
        // $this->eventsManager->collectResponses(true);
        
        // retrieve events based on the config roles and features
        $permissions = $this->config->pathToArray('permissions') ?? [];
        $featureList = $permissions['features'] ?? [];
        $roleList = $permissions['roles'] ?? [];
        
        foreach ($roleList as $role => $rolePermission) {
            // do not attach other roles behaviors
            if (!$this->identity->hasRole([$role])) {
                continue;
            }
            
            if (isset($rolePermission['features'])) {
                foreach ($rolePermission['features'] as $feature) {
                    $rolePermission = array_merge_recursive($rolePermission, $featureList[$feature] ?? []);
                    // @todo remove duplicates
                }
            }
            
            $behaviorsContext = $rolePermission['behaviors'] ?? [];
            foreach ($behaviorsContext as $className => $behaviors) {
                if (is_int($className) || get_class($this) === $className) {
                    $this->attachBehaviors($behaviors, 'rest');
                }
                if (method_exists($this, 'getModelName')) {
                    if ($this->getModelName() === $className) {
                        $this->attachBehaviors($behaviors, 'model');
                    }
                }
            }
        }
    }
    
    /**
     * Attach a behavior to the object.
     *
     * @param string $eventClass The behavior to attach.
     * @param string|null $eventType The event type to attach the behavior to. If null, the behavior will be attached to the default event type.
     * @param int|null $priority The priority of the behavior. If null, the behavior will be attached with the default priority.
     * 
     * @return void
     */
    public function attachBehavior(string $eventClass, ?string $eventType = null, ?int $priority = null): void
    {
        $event = new $eventClass();
        
        if ($event instanceof Injectable) {
            $event->setDI($this->getDI());
        }
        
        $eventType = $event->eventType ?? $eventType ?? 'rest';
        $priority = $event->priority ?? $priority ?? Manager::DEFAULT_PRIORITY;
        $this->eventsManager->attach($eventType, $event, $priority);
    }
    
    /**
     * Attach multiple behaviors to the object.
     *
     * @param array $behaviors An array of behaviors to attach.
     * @param string|null $eventType The event type to attach the behaviors to. If null, the behaviors will be attached to all event types.
     * @param int|null $priority The priority of the behaviors. If null, the behaviors will be attached with the default priority.
     * 
     * @return void
     */
    public function attachBehaviors(array $behaviors = [], ?string $eventType = null, ?int $priority = null): void
    {
        foreach ($behaviors as $behavior) {
            $this->attachBehavior($behavior, $eventType, $priority);
        }
    }
    
}
