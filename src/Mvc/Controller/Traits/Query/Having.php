<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractHaving;

trait Having
{
    use AbstractHaving;
    
    protected ?Collection $having;
    
    public function initializeHaving(): void
    {
        $this->setHaving(null);
    }
    
    public function setHaving(?Collection $having): void
    {
        $this->having = $having;
    }
    
    public function getHaving(): ?Collection
    {
        return $this->having;
    }
}
