<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Zemit\Mvc\Controller\Traits\Actions\ErrorActions;
use Zemit\Mvc\Controller\Traits\StatusCode;

class ErrorController extends AbstractController
{
    use ErrorActions;
    use StatusCode;
}
