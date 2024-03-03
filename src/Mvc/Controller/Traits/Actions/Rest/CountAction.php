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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\RestResponse;

trait CountAction
{
    use AbstractInjectable;
    use RestResponse;
    
    /**
     * Count a record list
     * Will use the getFind query
     * @throws Exception
     */
    public function countAction(): ResponseInterface
    {
        $model = $this->getModelClassName();
        
        $countResult = $model::count($this->getFindCount($this->getFind()));
        $count = is_countable($countResult) ? count($countResult) : (int)$countResult;
        
        $this->view->setVar('count', $count);
        return $this->setRestResponse(true);
    }
}
