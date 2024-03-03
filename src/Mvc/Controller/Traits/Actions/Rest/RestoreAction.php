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

use Phalcon\Filter\Exception;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractGetSingle;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;
use Zemit\Mvc\Controller\Traits\RestResponse;
use Zemit\Mvc\Model\Interfaces\SoftDeleteInterface;

trait RestoreAction
{
    use AbstractInjectable;
    use AbstractRestResponse;
    use AbstractGetSingle;
    
    /**
     * Restoring record
     * @throws Exception
     */
    public function restoreAction(?int $id = null): ResponseInterface
    {
        $entity = $this->getSingle($id);
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        assert($entity instanceof SoftDeleteInterface);
        $restore = $entity->restore();
        $this->view->setVars([
            'restore' => $restore,
            'single' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($restore);
    }
}
