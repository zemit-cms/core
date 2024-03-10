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

use Phalcon\Filter\Filter;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;

trait Offset
{
    use AbstractParams;
    
    protected ?int $offset;
    
    public function initializeOffset(): void
    {
        $offset = $this->getParam('offset', [Filter::FILTER_ABSINT], $this->defaultOffset());
        $this->setOffset($offset);
    }
    
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }
    
    public function getOffset(): ?int
    {
        return $this->offset === -1? null : $this->offset;
    }
    
    public function defaultOffset(): ?int
    {
        return 0;
    }
}
