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

use Zemit\Mvc\Controller\Traits\StatusCode;
use Zemit\Mvc\Controller\Traits\Actions\ErrorActions;

class Error extends \Zemit\Mvc\Controller
{
    use StatusCode;
    use ErrorActions;
}
