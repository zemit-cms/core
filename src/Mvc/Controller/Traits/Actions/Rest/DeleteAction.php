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
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractGetSingle;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait DeleteAction
{
    use AbstractExpose;
    use AbstractGetSingle;
    use AbstractInjectable;
    use AbstractRestResponse;
    
    /**
     * Deleting a record
     * @throws Exception
     */
    public function deleteAction(?int $id = null): ResponseInterface
    {
        $entity = $this->getSingle($id, null, []);
        
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
