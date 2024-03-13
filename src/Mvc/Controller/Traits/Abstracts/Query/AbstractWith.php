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

trait AbstractWith
{
    abstract public function initializeWith(): void;
    
    abstract public function setWith(?Collection $with): void;
    
    abstract public function getWith(): ?Collection;
}
