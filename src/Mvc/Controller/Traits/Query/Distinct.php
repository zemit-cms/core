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
    
    /**
     * Initialize the distinct parameter for the query.
     *
     * @return void
     * @throws \Phalcon\Filter\Exception If an error occurs during filtering
     */
    public function initializeDistinct(): void
    {
        $distinct = $this->getParam('distinct', [Filter::FILTER_STRING, Filter::FILTER_TRIM]);
        
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
    
    /**
     * Sets the distinct collection.
     *
     * @param Collection|null $distinct The distinct collection to set.
     *
     * @return void
     */
    public function setDistinct(?Collection $distinct): void
    {
        $this->distinct = $distinct;
    }
    
    /**
     * Gets the distinct collection.
     *
     * @return Collection|null The distinct collection, if set; otherwise, null.
     */
    public function getDistinct(): ?Collection
    {
        return $this->distinct;
    }
}
