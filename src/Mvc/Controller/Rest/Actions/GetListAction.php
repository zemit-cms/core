<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest\Actions;

use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;

trait GetListAction
{
    use AbstractInjectable;
    
    /**
     * @deprecated Should use getListAction() method instead
     */
    public function getAllAction(): ResponseInterface
    {
        return $this->getListAction();
    }
    
    /**
     * Retrieving a record list
     * @throws \Exception
     */
    public function getListAction(): ResponseInterface
    {
        $model = $this->getModelClassName();
        $with = $this->getListWith() ?: [];
        $find = $this->getFind() ?: [];
        
        $totalCount = $model::count($this->getFindCount($find));
        $totalCount = is_countable($totalCount) ? count($totalCount) : (int)$totalCount;
        $this->view->setVars([
            'list' => $this->listExpose($model::findWith($with, $find)),
            'totalCount' => $totalCount,
            'limit' => $find['limit'] ?? null,
            'offset' => $find['offset'] ?? null,
        ]);
        
        if ($this->isDebugEnabled()) {
            $this->view->setVars([
                'with' => $with,
                'find' => $find,
            ]);
        }
        
        return $this->setRestResponse(true);
    }
    
}
