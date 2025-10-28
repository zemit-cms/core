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

trait AbstractBind
{
    abstract public function initializeBind(): void;
    
    abstract public function initializeBindTypes(): void;
    
    abstract public function setBind(?Collection $bind): void;
    
    abstract public function getBind(): ?Collection;
    
    abstract public function setBindTypes(?Collection $bindTypes): void;
    
    abstract public function getBindTypes(): ?Collection;
}
