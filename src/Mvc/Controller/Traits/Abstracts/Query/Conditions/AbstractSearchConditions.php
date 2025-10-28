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

trait AbstractSearchConditions
{
    abstract public function initializeSearchConditions(): void;
    
    abstract public function setSearchConditions(?Collection $searchConditions): void;
    
    abstract public function getSearchConditions(): ?Collection;
    
    abstract public function defaultSearchCondition(): array|string|null;
}
