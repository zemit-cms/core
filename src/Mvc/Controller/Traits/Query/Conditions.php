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

namespace PhalconKit\Mvc\Controller\Traits\Query;

use Phalcon\Support\Collection;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\AbstractConditions;
use PhalconKit\Mvc\Controller\Traits\Query\Conditions\FilterConditions;
use PhalconKit\Mvc\Controller\Traits\Query\Conditions\IdentityConditions;
use PhalconKit\Mvc\Controller\Traits\Query\Conditions\PermissionConditions;
use PhalconKit\Mvc\Controller\Traits\Query\Conditions\SearchConditions;
use PhalconKit\Mvc\Controller\Traits\Query\Conditions\SoftDeleteConditions;

trait Conditions
{
    use AbstractConditions;
    
    use FilterConditions;
    use IdentityConditions;
    use PermissionConditions;
    use SearchConditions;
    use SoftDeleteConditions;
    
    protected ?Collection $conditions = null;
    
    public function initializeConditions(): void
    {
        $this->initializePermissionConditions();
        $this->initializeSoftDeleteConditions();
        $this->initializeIdentityConditions();
        $this->initializeFilterConditions();
        $this->initializeSearchConditions();
        
        $this->setConditions(new Collection([
            'permission' => $this->getPermissionConditions(),
            'softDelete' => $this->getSoftDeleteConditions(),
            'identity' => $this->getIdentityConditions(),
            'filter' => $this->getFilterConditions(),
            'search' => $this->getSearchConditions(),
        ], false));
    }
    
    public function setConditions(?Collection $conditions): void
    {
        $this->conditions = $conditions;
    }
    
    public function getConditions(): ?Collection
    {
        return $this->conditions;
    }
}
