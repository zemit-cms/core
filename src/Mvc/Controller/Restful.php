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

use Zemit\Mvc\Controller\Rest\Actions;
use Zemit\Mvc\Controller\Rest\Expose;

class Restful extends Rest
{
    use Model;
    
    // Rest Helpers
    use Expose;
    use Actions;
}
