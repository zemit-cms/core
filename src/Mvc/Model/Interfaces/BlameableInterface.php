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

namespace Zemit\Mvc\Model\Interfaces;

use Phalcon\Mvc\Model\Relation;
use Zemit\Mvc\Model\Behavior\Blameable;
use Zemit\Mvc\Model\Interfaces\Blameable\BlameAtInterface;
use Zemit\Mvc\Model\Interfaces\Blameable\CreatedInterface;
use Zemit\Mvc\Model\Interfaces\Blameable\DeletedInterface;
use Zemit\Mvc\Model\Interfaces\Blameable\RestoredInterface;
use Zemit\Mvc\Model\Interfaces\Blameable\UpdatedInterface;

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
