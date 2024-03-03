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
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait NewAction
{
    use AbstractExpose;
    use AbstractInjectable;
    use AbstractModel;
    use AbstractParams;
    use AbstractRestResponse;
    
    /**
     * Prepare a new unsaved model
     * This is useful if you want the default values
     * @throws Exception
     */
    public function newAction(): ResponseInterface
    {
        $model = $this->getModelName();
        
        $entity = new $model();
        assert($entity instanceof ModelInterface);
        
        $entity->assign($this->getParams(), $this->getWhiteList(), $this->getColumnMap());
        
        $this->view->setVar('single', $this->expose($entity));
        return $this->setRestResponse(true);
    }
    
}
