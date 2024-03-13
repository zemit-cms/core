<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractFilterConditions;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractIdentityConditions;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractPermissionConditions;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractSearchConditions;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractSoftDeleteConditions;

trait AbstractConditions
{
    use AbstractFilterConditions;
    use AbstractIdentityConditions;
    use AbstractPermissionConditions;
    use AbstractSearchConditions;
    use AbstractSoftDeleteConditions;
    
    abstract public function initializeConditions(): void;
    
    abstract public function setConditions(?Collection $conditions): void;
    
    abstract public function getConditions(): ?Collection;
    
}
