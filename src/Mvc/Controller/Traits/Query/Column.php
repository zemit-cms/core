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
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\AbstractColumn;

trait Column
{
    use AbstractColumn;
    
    protected ?Collection $column = null;
    
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
