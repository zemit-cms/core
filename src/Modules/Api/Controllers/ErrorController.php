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

use Zemit\Mvc\Controller\Errors;
use Zemit\Mvc\Controller\StatusCode;

class ErrorController extends AbstractController
{
    use Errors;
    use StatusCode;
}
