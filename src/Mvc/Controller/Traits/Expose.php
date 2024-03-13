<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractExposeFields;
use Zemit\Mvc\Model\Interfaces\ExposeInterface;
use Zemit\Support\Exposer\Exposer;

trait Expose
{
    use AbstractExposeFields;
    
    /**
     * Expose properties of an item
     *
     * @param mixed $item The item to expose properties for
     * @param array|null $expose The array defining which properties to expose (optional).
     *                           If not provided, the default $this->getExpose() method will be used.
     *
     * @return array The exposed properties as an array
     */
    public function expose(mixed $item, ?array $expose = null): array
    {
        $expose ??= $this->getExposeFields()?->toArray();
        
        if ($item instanceof ExposeInterface) {
            return $item->expose($expose);
        }
        
        $exposeBuilder = Exposer::createBuilder($item, $expose);
        return Exposer::expose($exposeBuilder);
    }
    
    /**
     * List entities with specified expose definition
     *
     * @param iterable $items The iterable collection of items to be listed
     * @param array|null $expose The expose definition for the entities (optional)
     *                           If not provided, the default $this->getListExpose() method will be used.
     *
     * @return array The array of exposed entities
     */
    public function listExpose(iterable $items, ?array $expose = null): array
    {
        $expose ??= $this->getExposeFields()?->toArray();
        
        $ret = [];
        foreach ($items as $item) {
            $ret [] = $this->expose($item, $expose);
        }
        
        return $ret;
    }
    
    /**
     * Export items with expose definition
     *
     * @param iterable $items The items to be exported
     * @param array|null $expose The expose definition for the items. 
     *                           If not provided, the default $this->getExportExpose() definition will be used.
     * 
     * @return array The exported items
     */
    public function exportExpose(iterable $items, ?array $expose = null): array
    {
        $expose ??= $this->getExposeFields()?->toArray();
        return $this->listExpose($items, $expose);
    }
}
