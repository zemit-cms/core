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
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;

trait AbstractFilterConditions
{
    abstract public function initializeFilterConditions(): void;
    
    abstract public function setFilterConditions(?Collection $filterConditions): void;
    
    abstract public function getFilterConditions(): ?Collection;
    
    abstract public function defaultFilterCondition(array $filters = null, array $allowedFilters = null, bool $or = false): array|string|null;
    
    abstract public function getFilterOperator(string $operator): string;
    
    abstract public function getBindTypeFromRawValue(mixed $rawValue = null): int;
    
}
