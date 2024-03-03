<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Zemit\Mvc\Controller\Traits\Actions\RestActions;
use Zemit\Mvc\Controller\Traits\Expose;
use Zemit\Mvc\Controller\Traits\Query;

class RestfulController extends RestController
{
    use Query;
    
    // Rest Helpers
    use Expose;
    use RestActions;
}
