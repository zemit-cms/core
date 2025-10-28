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

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields;

use Phalcon\Support\Collection;

/**
 * The AbstractFilterFields trait provides a base implementation for filtering fields.
 */
trait AbstractFilterFields
{
    abstract public function initializeFilterFields(): void;
    
    abstract public function setFilterFields(?Collection $filterFields): void;
    
    abstract public function getFilterFields(): ?Collection;
}
