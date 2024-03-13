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

use Phalcon\Filter\Exception;
use Phalcon\Filter\Filter;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;

/**
 * This trait provides functionality to set and get an offset value for a query.
 */
trait AbstractOffset
{
    abstract public function initializeOffset(): void;
    
    abstract public function setOffset(?int $offset): void;
    
    abstract public function getOffset(): ?int;
    
    abstract public function defaultOffset(): ?int;
}
