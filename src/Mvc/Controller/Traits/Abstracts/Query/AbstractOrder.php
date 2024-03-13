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

use Phalcon\Support\Collection;

trait AbstractOrder
{
    abstract public function initializeDefaultOrder(): void;
    
    abstract public function initializeOrder(): void;
    
    abstract public function setOrder(?Collection $order): void;
    
    abstract public function getOrder(): ?Collection;
    
    abstract public function setDefaultOrder(array|string|null $defaultOrder): void;
    
    abstract public function getDefaultOrder(): array|string|null;
}
