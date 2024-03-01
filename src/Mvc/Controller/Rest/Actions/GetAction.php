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

trait GetAction
{
    use AbstractInjectable;
    use AbstractGetSingle;
    
    /**
     * @deprecated Should use getAction() method instead
     */
    public function getSingleAction(string|int $id = null): ResponseInterface
    {
        return $this->getAction($id);
    }
    
    /**
     * Retrieving a single record
     * @throws Exception
     */
    public function getAction(string|int $id = null): ResponseInterface
    {
        $entity = $this->getSingle($id);
        
        if (!$entity) {
            return $this->setRestErrorResponse(404);
        }
        
        $this->view->setVar('single', $this->expose($entity));
        return $this->setRestResponse(true);
    }
    
}
