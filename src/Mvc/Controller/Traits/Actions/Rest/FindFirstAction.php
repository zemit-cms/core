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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait FindFirstAction
{
    use AbstractExpose;
    use AbstractQuery;
    use AbstractInjectable;
    use AbstractRestResponse;
    
    /**
     * Retrieving a single record
     * @link findFirstAction()
     * @deprecated use {@link findFirstAction()}
     * @throws \Exception
     */
    public function getAction(): ResponseInterface
    {
        return $this->findFirstAction();
    }
    
    /**
     * Retrieving a single record
     * @link findFirstWithAction()
     * @deprecated use {@link findFirstWithAction()}
     * @throws \Exception
     */
    public function getWithAction(): ResponseInterface
    {
        return $this->findFirstWithAction();
    }
    
    /**
     * Retrieving a single record
     * @throws \Exception
     */
    public function findFirstAction(): ResponseInterface
    {
        $result = $this->findFirst();
        
        if (!$result) {
            return $this->setRestErrorResponse(404);
        }
        
        $this->view->setVar('data', $this->expose($result));
        return $this->setRestResponse(true);
    }
    
    /**
     * Retrieving a single record
     * @throws \Exception
     */
    public function findFirstWithAction(): ResponseInterface
    {
        $result = $this->findFirstWith();
        
        if (!$result) {
            return $this->setRestErrorResponse(404);
        }
        
        $this->view->setVar('data', $this->expose($result));
        return $this->setRestResponse(true);
    }
}
