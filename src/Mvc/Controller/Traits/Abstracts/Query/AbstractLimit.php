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

/**
 * The Limit trait provides methods to handle query limits.
 */
trait AbstractLimit
{
    abstract public function initializeLimit(): void;
    
    abstract public function setLimit(?int $limit): void;
    
    abstract public function getLimit(): ?int;
    
    abstract public function setMaxLimit(?int $maxLimit): void;
    
    abstract public function getMaxLimit(): ?int;
    
    abstract public function defaultLimit(): ?int;
    
    abstract public function defaultMaxLimit(): ?int;
}
