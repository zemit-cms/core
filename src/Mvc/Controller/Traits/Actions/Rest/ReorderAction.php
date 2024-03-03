<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Actions\Rest;

use Exception;
use Phalcon\Filter\Filter;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractGetSingle;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;
use Zemit\Mvc\Controller\Traits\RestResponse;

trait ReorderAction
{
    use AbstractInjectable;
    use AbstractRestResponse;
    use AbstractGetSingle;
    
    /**
     * Re-ordering a position
     * @throws Exception
     */
    public function reorderAction(?int $id = null, ?int $position = null): ResponseInterface
    {
        $entity = $this->getSingle($id);
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        $position ??= $this->getParam('position', [Filter::FILTER_INT]);
        
        $reorder = $entity->reorder($position);
        $this->view->setVars([
            'reorder' => $reorder,
            'single' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($reorder);
    }
}
