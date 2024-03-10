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

trait Limit
{
    use AbstractParams;
    
    protected ?int $limit;
    protected ?int $maxLimit = 1000;
    
    public function initializeLimit(): void
    {
        $limit = $this->getParam('limit', [Filter::FILTER_ABSINT], $this->defaultLimit());
        $this->setLimit($limit);
        $this->setMaxLimit($this->defaultMaxLimit());
    }
    
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }
    
    public function getLimit(): ?int
    {
        if (isset($this->maxLimit) && $this->maxLimit !== -1) {
            if ($this->limit > $this->maxLimit) {
                throw new \Exception("Requested limit ({$this->limit}) must be lower than the maximum limit ({$this->maxLimit})", 400);
            }
        }
        
        return $this->limit === -1? null : $this->limit;
    }
    
    public function setMaxLimit(?int $maxLimit): void
    {
        $this->maxLimit = $maxLimit;
    }
    
    public function getMaxLimit(): ?int
    {
        return $this->maxLimit;
    }
    
    public function defaultLimit(): ?int
    {
        return 100;
    }
    
    public function defaultMaxLimit(): ?int
    {
        return 1000;
    }
}
