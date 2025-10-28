<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\Model\BehaviorInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\ManagerInterface;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractModelsManager;

/**
 * Trait Behavior
 *
 * This trait provides methods to manipulate behaviors for models.
 */
trait Behavior
{
    use AbstractModelsManager;
    
    /**
     * Retrieves a behavior by its name.
     *
     * @param string $behaviorName The name of the behavior to retrieve.
     *
     * @return ?BehaviorInterface The behavior instance.
     */
    public function getBehavior(string $behaviorName): ?BehaviorInterface
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        return $modelsManager->getBehavior($this, $behaviorName);
    }
    
    /**
     * Sets a behavior for the model.
     *
     * @param string $behaviorName The name of the behavior to set.
     * @param BehaviorInterface $behavior The behavior instance to set.
     *
     * @return void
     */
    public function setBehavior(string $behaviorName, BehaviorInterface $behavior): void
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        $modelsManager->setBehavior($this, $behaviorName, $behavior);
    }
    
    /**
     * Checks if the model has a specific behavior.
     *
     * @param string $behaviorName The name of the behavior to check for.
     *
     * @return bool Returns true if the model has the specified behavior, otherwise false.
     */
    public function hasBehavior(string $behaviorName): bool
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        return $modelsManager->hasBehavior($this, $behaviorName);
    }
    
    /**
     * Removes a behavior from the model.
     *
     * @param string $behaviorName The name of the behavior to remove.
     *
     * @return void
     */
    public function removeBehavior(string $behaviorName): void
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        $modelsManager->removeBehavior($this, $behaviorName);
    }
}
