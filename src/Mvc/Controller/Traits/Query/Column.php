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

trait Column
{
    protected ?Collection $column;
    
    public function initializeColumn(): void
    {
        $this->setColumn(null);
    }
    
    public function setColumn(?Collection $column): void
    {
        $this->column = $column;
    }
    
    public function getColumn(): ?Collection
    {
        return $this->column;
    }
}
