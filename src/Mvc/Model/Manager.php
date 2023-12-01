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

use Phalcon\Mvc\Model\Manager as PhalconModelsManager;
use Phalcon\Mvc\Model\BehaviorInterface;
use Phalcon\Mvc\ModelInterface;

class Manager extends PhalconModelsManager implements ManagerInterface
{
    public function getBehaviors(): array
    {
        return $this->behaviors;
    }
    
    public function setBehaviors(array $behaviors): void
    {
        $this->behaviors = $behaviors;
    }
    
    /**
     * Get a behavior using the behavior name
     */
    public function getBehavior(ModelInterface $model, string $behaviorName)
    {
        $entityName = strtolower(get_class($model));
        
        return $this->behaviors[$entityName][$behaviorName] ?? null;
    }
    
    /**
     * Set a behavior using the behavior name
     */
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
    public function hasBehavior(ModelInterface $model, string $behaviorName): bool
    {
        $entityName = strtolower(get_class($model));
        
        return isset($this->behaviors[$entityName][$behaviorName]);
    }
    
    /**
     * Merge two arrays of find parameters
     */
    public function mergeFindParameters(?array $findParamsOne = [], ?array $findParamsTwo = []): array
    {
        return $this->_mergeFindParameters($findParamsOne, $findParamsTwo);
    }
}
