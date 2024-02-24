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

use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;

trait NewAction {
    
    use AbstractInjectable;
    
    /**
     * Prepare a new unsaved model
     * This is useful if you want the default values
     * @throws Exception
     */
    public function newAction(): ResponseInterface
    {
        $model = $this->getModelClassName();
        
        $entity = new $model();
        assert($entity instanceof ModelInterface);
        
        $entity->assign($this->getParams(), $this->getWhiteList(), $this->getColumnMap());
        
        $this->view->setVar('single', $this->expose($entity));
        return $this->setRestResponse(true);
    }
    
}
