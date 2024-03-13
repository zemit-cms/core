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

trait AbstractGroup
{
    abstract public function initializeGroup(): void;
    
    abstract public function setGroup(?Collection $group): void;
    
    abstract public function getGroup(): ?Collection;
    
    abstract public function defaultGroup(): array|string|null;
    
}
