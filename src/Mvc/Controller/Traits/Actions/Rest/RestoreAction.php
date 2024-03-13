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

use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;
use Zemit\Mvc\Model\Interfaces\SoftDeleteInterface;

trait RestoreAction
{
    use AbstractExpose;
    use AbstractInjectable;
    use AbstractQuery;
    use AbstractRestResponse;
    
    /**
     * Restores a soft-deleted entity.
     *
     * @return ResponseInterface The response indicating the status of the restoration.
     * @throws \Exception
     */
    public function restoreAction(): ResponseInterface
    {
        $entity = $this->findFirst();
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        assert($entity instanceof SoftDeleteInterface);
        assert($entity instanceof ModelInterface);
        $restored = $entity->restore();
        
        $this->view->setVars([
            'restore' => $restored,
            'single' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($restored);
    }
}
