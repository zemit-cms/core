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
use Phalcon\Filter\Filter;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;

trait Order
{
    use AbstractParams;
    
    protected ?Collection $order;
    
    // @todo add model name to order attributes
    public function initializeOrder(): void
    {
        $order = $this->getParam('order', [Filter::FILTER_STRING, Filter::FILTER_TRIM], $this->defaultOrder());
        
        if (!isset($order)) {
            $this->setOrder(null);
            return;
        }
        
        if (!is_array($order)) {
            $order = explode(',', $order);
        }
        
        foreach ($order as $key => $item) {
            if (is_int($key)) {
                if (!is_array($item)) {
                    $item = explode(' ', $item);
                    $order[trim($item[0])] = trim($item[1] ?? 'asc');
                }
            }
            unset($order[$key]);
        }
        
        $this->setOrder(new Collection($order, false));
    }
    
    public function setOrder(?Collection $order): void
    {
        $this->order = $order;
    }
    
    public function getOrder(): ?Collection
    {
        return $this->order;
    }
    
    public function defaultOrder(): array|string|null
    {
        return null;
    }
}
