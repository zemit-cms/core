<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Support\Collection;

trait AbstractSoftDeleteConditions
{
    abstract public function initializeSoftDeleteConditions(): void;
    
    abstract public function setSoftDeleteConditions(?Collection $softDeleteConditions): void;
    
    abstract public function getSoftDeleteConditions(): ?Collection;
    
    abstract public function defaultSoftDeleteCondition(): array|string|null;
    
}
