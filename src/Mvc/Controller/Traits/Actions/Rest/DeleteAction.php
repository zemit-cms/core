<?php

declare(strict_types=1);

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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait DeleteAction
{
    use AbstractExpose;
    use AbstractQuery;
    use AbstractInjectable;
    use AbstractRestResponse;
    
    /**
     * Deleting a record
     * @throws Exception
     */
    public function deleteAction(): ResponseInterface
    {
        $entity = $this->findFirst();
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        $deleted = $entity->delete();
        $this->view->setVars([
            'deleted' => $deleted,
            'data' => $this->expose($entity),
            'messages' => $entity->getMessages(),
        ]);
        
        return $this->setRestResponse($deleted);
    }
}
