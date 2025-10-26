<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\Model\BehaviorInterface;
use Phalcon\Mvc\Model\Manager as PhalconModelsManager;
use Phalcon\Mvc\ModelInterface;

class Manager extends PhalconModelsManager implements ManagerInterface
{
    /**
     * Retrieve all behaviors.
     */
    #[\Override]
    public function getBehaviors(): array
    {
        return $this->behaviors;
    }
    
    /**
     * Replaces the current behaviors with a new set of behaviors.
     */
    #[\Override]
    public function setBehaviors(array $behaviors): void
    {
        $this->behaviors = $behaviors;
    }
    
    /**
     * Get a behavior using the behavior name
     */
    #[\Override]
    public function getBehavior(ModelInterface $model, string $behaviorName): ?BehaviorInterface
    {
        $entityName = strtolower(get_class($model));
        
        return $this->behaviors[$entityName][$behaviorName] ?? null;
    }
    
    /**
     * Set a behavior using the behavior name
     */
    #[\Override]
    public function setBehavior(ModelInterface $model, string $behaviorName, BehaviorInterface $behavior): void
    {
        $entityName = strtolower(get_class($model));
        
        if (!isset($this->behaviors[$entityName])) {
            $this->behaviors[$entityName] = [];
        }
        
        $this->behaviors[$entityName][$behaviorName] = $behavior;
    }
    
    /**
     * Return true if the behavior is set
     */
    #[\Override]
    public function hasBehavior(ModelInterface $model, string $behaviorName): bool
    {
        $entityName = strtolower(get_class($model));
        
        return isset($this->behaviors[$entityName][$behaviorName]);
    }
    
    /**
     * Removes a behavior associated with the given model and behavior name.
     */
    #[\Override]
    public function removeBehavior(ModelInterface $model, string $behaviorName): void
    {
        $entityName = strtolower(get_class($model));
        
        if (isset($this->behaviors[$entityName][$behaviorName])) {
            unset($this->behaviors[$entityName][$behaviorName]);
        }
    }
    
    /**
     * Merge two arrays of find parameters
     */
//    public function _mergeFindParameters(?array $findParamsOne = [], ?array $findParamsTwo = []): array
//    {
//        return $this->mergeFindParameters($findParamsOne, $findParamsTwo);
//    }
}
