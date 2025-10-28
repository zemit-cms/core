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
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait SumAction
{
    use AbstractInjectable;
    use AbstractQuery;
    use AbstractRestResponse;
    
    /**
     * Calculates the sum of a column.
     *
     * @return ResponseInterface The REST response with a status of true.
     * @throws Exception
     */
    public function sumAction(): ResponseInterface
    {
        $this->view->setVar('sum', $this->sum());
        return $this->setRestResponse(true);
    }
}
