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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait MinimumAction
{
    use AbstractInjectable;
    use AbstractQuery;
    use AbstractRestResponse;
    
    /**
     * Minimum value of a column
     * Alias for minimumAction
     * @link minimumAction()
     * @throws Exception
     */
    public function minAction(): ResponseInterface
    {
        return $this->maximumAction();
    }
    
    /**
     * Minimum value of a column
     * @throws Exception
     */
    public function minimumAction(): ResponseInterface
    {
        $this->view->setVar('minimum', $this->minimum());
        return $this->setRestResponse(true);
    }
}
