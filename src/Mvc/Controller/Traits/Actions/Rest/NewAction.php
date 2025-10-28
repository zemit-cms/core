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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractFields;

trait NewAction
{
    use AbstractExpose;
    use AbstractInjectable;
    use AbstractModel;
    use AbstractParams;
    use AbstractRestResponse;
    use AbstractFields;
    
    /**
     * Prepare a new unsaved model
     * This is useful if you want the default values
     * @throws Exception
     */
    public function newAction(): ResponseInterface
    {
        $entity = $this->loadModel();
        
        $params = $this->getParams();
        $saveFields = $this->getSaveFields()?->toArray();
        $mapFields = $this->getMapFields()?->toArray();
        $entity->assign($params, $saveFields, $mapFields);
        
        $this->view->setVar('data', $this->expose($entity));
        return $this->setRestResponse(true);
    }
}
