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
use Phalcon\Mvc\Model\ManagerInterface as PhalconModelsManagerInterface;
use Phalcon\Mvc\ModelInterface;

interface ManagerInterface extends PhalconModelsManagerInterface
{
    public function getBehaviors(): array;
    
    public function setBehaviors(array $behaviors): void;
    
    public function getBehavior(ModelInterface $model, string $behaviorName);
    
    public function setBehavior(ModelInterface $model, string $behaviorName, BehaviorInterface $behavior): void;
    
    public function hasBehavior(ModelInterface $model, string $behaviorName): bool;
    
//    public function mergeFindParameters(array $findParamsOne = [], array $findParamsTwo = []): array;
}
