<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller\Traits\Query;

use Phalcon\Support\Collection;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\AbstractHaving;

trait Having
{
    use AbstractHaving;
    
    protected ?Collection $having = null;
    
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
