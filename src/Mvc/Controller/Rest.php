<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller;

use PhalconKit\Mvc\Controller\Traits\Behavior;
use PhalconKit\Mvc\Controller\Traits\Debug;
use PhalconKit\Mvc\Controller\Traits\Fractal;
use PhalconKit\Mvc\Controller\Traits\Params;
use PhalconKit\Mvc\Controller\Traits\RestResponse;

class Rest extends \PhalconKit\Mvc\Controller implements RestInterface
{
    use Behavior;
    use Debug;
    use Fractal;
    use Params;
    use RestResponse;
}
