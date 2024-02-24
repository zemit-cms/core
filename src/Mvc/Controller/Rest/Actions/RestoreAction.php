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
use Zemit\Mvc\Controller\Rest\Response;

trait RestoreAction
{
    use AbstractInjectable;
    use Response;
    
    /**
     * Restoring record
     */
    public function restoreAction(string|int $id = null): ResponseInterface
    {
        $entity = $this->getSingle($id);
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        $restore = $entity->restore();
        $this->view->setVars([
            'restore' => $restore,
            'single' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($restore);
    }
}
