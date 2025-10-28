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
 * The AbstractSearchFields trait provides a base implementation for searching fields.
 */
trait AbstractSearchFields
{
    abstract public function initializeSearchFields(): void;
    
    abstract public function setSearchFields(?Collection $searchFields): void;
    
    abstract public function getSearchFields(): ?Collection;
}
