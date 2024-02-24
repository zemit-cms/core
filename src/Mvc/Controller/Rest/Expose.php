<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest;

use Phalcon\Mvc\ModelInterface;
use Zemit\Support\Exposer\Exposer;

trait Expose
{
    /**
     * Expose a single model
     */
    public function expose(ModelInterface $item, ?array $expose = null): array
    {
        $expose ??= $this->getExpose();
        
        if ($item instanceof \Zemit\Mvc\Model) {
            return $item->expose($expose);
        }
        
        $exposeBuilder = Exposer::createBuilder($item, $expose);
        return Exposer::expose($exposeBuilder);
    }
    
    /**
     * Expose a list of models
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
     * Expose a list of model
     */
    public function exportExpose(iterable $items, $exportExpose = null): array
    {
        $exportExpose ??= $this->getExportExpose();
        return $this->listExpose($items, $exportExpose);
    }
}
