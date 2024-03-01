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

use Exception;
use Phalcon\Filter\Filter;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractGetSingle;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Controller\Rest\Response;

trait ReorderAction
{
    use AbstractInjectable;
    use AbstractGetSingle;
    use Response;
    
    /**
     * Re-ordering a position
     * @throws Exception
     */
    public function reorderAction(string|int $id = null, int $position = null): ResponseInterface
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
