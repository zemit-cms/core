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

trait AbstractHaving
{
    abstract public function initializeHaving(): void;
    
    abstract public function setHaving(?Collection $having): void;
    
    abstract public function getHaving(): ?Collection;
}
