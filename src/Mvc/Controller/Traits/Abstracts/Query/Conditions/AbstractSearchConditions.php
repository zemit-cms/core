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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Support\Collection;

trait AbstractSearchConditions
{
    abstract public function initializeSearchConditions(): void;
    
    abstract public function setSearchConditions(?Collection $searchConditions): void;
    
    abstract public function getSearchConditions(): ?Collection;
    
    abstract public function defaultSearchCondition(): array|string|null;
}
