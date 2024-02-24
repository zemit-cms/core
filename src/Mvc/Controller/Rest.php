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

use Zemit\Mvc\Controller\Rest\Fractal;
use Zemit\Mvc\Controller\Rest\Response;

class Rest extends \Zemit\Mvc\Controller
{
    // Helpers
    use Debug;
    use Behavior;
    
    // Rest Helpers
    use Params;
    use Fractal;
    use Response;
}
