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

use Phalcon\Assets\Collection;
use Zemit\Mvc\Model\Interfaces\ExposeInterface;
use Zemit\Support\Exposer\Exposer;

trait Expose
{
    /**
     * Get expose definition for an item
     *
     * @return array|null The exposed properties, or null for everything.
     */
    protected function getExpose(): ?array
    {
        return null;
    }
    
    /**
     * Get expose definition for a list of entities
     *
     * @return null|array The exposed properties, or null for everything.
     */
    protected function getListExpose(): ?array
    {
        return $this->getExpose();
    }
    
    /**
     * Get expose definition for exporting
     *
     * @return null|array The exposed properties, or null for everything.
     */
    protected function getExportExpose(): ?array
    {
        return $this->getExpose();
    }
    
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
        $expose ??= $this->getExpose();
        
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
     * @param array|null $listExpose The expose definition for the entities (optional)
     *                               If not provided, the default $this->getListExpose() method will be used.
     *
     * @return array The array of exposed entities
     */
    public function listExpose(iterable $items, ?array $listExpose = null): array
    {
        $listExpose ??= $this->getListExpose();
        $ret = [];
        
        foreach ($items as $item) {
            $ret [] = $this->expose($item, $listExpose);
        }
        
        return $ret;
    }
    
    /**
     * Export items with expose definition
     *
     * @param iterable $items The items to be exported
     * @param array|null $exportExpose The expose definition for the items. 
     *                                 If not provided, the default $this->getExportExpose() definition will be used.
     * 
     * @return array The exported items
     */
    public function exportExpose(iterable $items, ?array $exportExpose = null): array
    {
        $exportExpose ??= $this->getExportExpose();
        return $this->listExpose($items, $exportExpose);
    }
}
