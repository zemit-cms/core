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

use Phalcon\Filter\Exception;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractGetSingle;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Controller\Rest\Response;

trait DeleteAction
{
    use AbstractInjectable;
    use AbstractGetSingle;
    use Response;
    
    /**
     * Deleting a record
     * @throws Exception
     */
    public function deleteAction(string|int $id = null): ResponseInterface
    {
        $entity = $this->getSingle($id);
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        $delete = $entity->delete();
        $this->view->setVars([
            'delete' => $delete,
            'single' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($delete);
    }
}
