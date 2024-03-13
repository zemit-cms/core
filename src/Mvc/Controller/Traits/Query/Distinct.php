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
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;

trait Distinct
{
    use AbstractParams;
    
    protected ?Collection $distinct;
    
    // @todo add model name to distinct attributes
    public function initializeDistinct(): void
    {
        $distinct = $this->getParam('distinct', [Filter::FILTER_STRING, Filter::FILTER_TRIM], $this->defaultDistinct());
        
        if (!isset($distinct)) {
            $this->setDistinct(null);
            return;
        }
        
        if (!is_array($distinct)) {
            $distinct = explode(',', $distinct);
        }
        
        foreach ($distinct as $key => $item) {
            if (is_int($key)) {
                $distinct[trim($item)] = true;
            }
            unset($distinct[$key]);
        }
        
        $this->setDistinct(new Collection($distinct, false));
    }
    
    public function setDistinct(?Collection $distinct): void
    {
        $this->distinct = $distinct;
    }
    
    public function getDistinct(): ?Collection
    {
        return $this->distinct;
    }
    
    public function defaultDistinct(): array|string|null
    {
        return null;
    }
}
