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
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Controller\Rest\Response;

trait CountAction
{
    use AbstractInjectable;
    use Response;
    
    /**
     * Count a record list
     * Will use the getFind query
     * @throws Exception
     */
    public function countAction(): ResponseInterface
    {
        $model = $this->getModelClassName();
        
        $countResult = $model::count($this->getFindCount($this->getFind()));
        $count = is_array($countResult) ? count($countResult) : $countResult;
        
        $this->view->setVar('count', $count);
        return $this->setRestResponse(true);
    }
}
