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

use Zemit\Mvc\Controller\Traits\Behavior;
use Zemit\Mvc\Controller\Traits\Debug;
use Zemit\Mvc\Controller\Traits\Fractal;
use Zemit\Mvc\Controller\Traits\Params;
use Zemit\Mvc\Controller\Traits\RestResponse;

class Rest extends \Zemit\Mvc\Controller implements RestInterface
{
    use Behavior;
    use Debug;
    use Fractal;
    use Params;
    use RestResponse;
}
