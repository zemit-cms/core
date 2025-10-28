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

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;

trait AbstractIdentityConditions
{
    abstract public function initializeIdentityConditions(): void;
    
    abstract public function setIdentityConditions(?Collection $identityConditions): void;
    
    abstract public function getIdentityConditions(): ?Collection;
    
    abstract public function defaultIdentityCondition(): array|string|null;
    
    abstract public function getIdentityColumns(): array;
}
