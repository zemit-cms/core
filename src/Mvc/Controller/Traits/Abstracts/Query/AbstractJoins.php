<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed joins this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;

trait AbstractJoins
{
    abstract public function initializeJoins(): void;
    
    abstract public function setJoins(?Collection $joins): void;
    
    abstract public function getJoins(): ?Collection;
}
