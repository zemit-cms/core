<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Interfaces\Blameable;

use Zemit\Mvc\Model\Behavior\Transformable;

interface DeletedInterface
{
    public function initializeDeleted(?array $options = null): void;

    public function setDeletedBehavior(Transformable $deletedBehavior): void;
    
    public function getDeletedBehavior(): Transformable;

}
