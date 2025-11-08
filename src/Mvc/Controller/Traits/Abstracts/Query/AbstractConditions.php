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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractFilterConditions;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractIdentityConditions;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractPermissionConditions;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractSearchConditions;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions\AbstractSoftDeleteConditions;

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
