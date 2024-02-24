<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Zemit\Di\Injectable;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;

trait Behavior
{
    use AbstractInjectable;
    
    public function beforeExecuteRoute(Dispatcher $dispatcher): void
    {
        // @todo use eventsManager from service provider instead
        $this->eventsManager->enablePriorities(true);
        
        // @todo see if we can implement receiving an array of responses globally: V2
        // $this->eventsManager->collectResponses(true);
        
        // retrieve events based on the config roles and features
        $permissions = $this->config->get('permissions')->toArray() ?? [];
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
                if (method_exists($this, 'getModelClassName')) {
                    if ($this->getModelClassName() === $className) {
                        $this->attachBehaviors($behaviors, 'model');
                    }
                }
            }
        }
    }
    
    /**
     * Attach a behavior to the events' manager.
     *
     * @param string $behavior The name of the behavior to attach.
     * @param string $eventType Optional. The event type to attach the behavior to. Default is 'rest'.
     *
     * @return void
     */
    public function attachBehavior(string $behavior, string $eventType = 'rest'): void
    {
        $event = new $behavior();
        
        // inject DI
        if ($event instanceof Injectable || method_exists($event, 'setDI')) {
            $event->setDI($this->getDI());
        }
        
        // attach behavior
        $this->eventsManager->attach($event->eventType ?? $eventType, $event, $event->priority ?? Manager::DEFAULT_PRIORITY);
    }
    
    /**
     * Attach behaviors to the current object.
     *
     * @param array $behaviors The array of behaviors to attach.
     * @param string $eventType The event type to attach the behaviors to. Default is 'rest'.
     *
     * @return void
     */
    public function attachBehaviors(array $behaviors = [], string $eventType = 'rest'): void
    {
        foreach ($behaviors as $behavior) {
            $this->attachBehavior($behavior, $eventType);
        }
    }
    
}
