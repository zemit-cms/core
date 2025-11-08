<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Model\Interfaces;

use Phalcon\Mvc\Model\Relation;
use PhalconKit\Mvc\Model\Behavior\Blameable;
use PhalconKit\Mvc\Model\Interfaces\Blameable\BlameAtInterface;
use PhalconKit\Mvc\Model\Interfaces\Blameable\CreatedInterface;
use PhalconKit\Mvc\Model\Interfaces\Blameable\DeletedInterface;
use PhalconKit\Mvc\Model\Interfaces\Blameable\RestoredInterface;
use PhalconKit\Mvc\Model\Interfaces\Blameable\UpdatedInterface;

interface BlameableInterface extends
    BlameAtInterface,
    CreatedInterface,
    DeletedInterface,
    RestoredInterface,
    UpdatedInterface
{
    public function initializeBlameable(?array $options = null): void;
    
    public function setBlameableBehavior(Blameable $blameableBehavior): void;
    
    public function getBlameableBehavior(): Blameable;
    
    public function addUserRelationship(
        string $field = 'userId',
        string $alias = 'UserEntity',
        array $params = [],
        string $ref = 'id',
        string $type = 'belongsTo',
        ?string $class = null
    ): ?Relation;
}
