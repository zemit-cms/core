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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait MaxAction
{
    use AbstractInjectable;
    use AbstractModel;
    use AbstractRestResponse;
    
    /**
     * Maximum value of a column
     * Will use the getFind query
     * @throws Exception
     */
    public function maxAction(): ResponseInterface
    {
        // @todo
    }
}
