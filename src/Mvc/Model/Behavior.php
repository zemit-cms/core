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
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractModelsManager;

trait Behavior
{
    use AbstractModelsManager;
    
    public function getBehavior(string $behaviorName): BehaviorInterface
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        return $modelsManager->getBehavior($this, $behaviorName);
    }
    
    public function setBehavior(string $behaviorName, BehaviorInterface $behavior): void
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        $modelsManager->setBehavior($this, $behaviorName, $behavior);
    }
    
    public function hasBehavior(string $behaviorName): bool
    {
        $modelsManager = $this->getModelsManager();
        assert($modelsManager instanceof ManagerInterface);
        assert($this instanceof ModelInterface);
        return $modelsManager->hasBehavior($this, $behaviorName);
    }
}
