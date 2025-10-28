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

namespace Zemit\Modules\Admin\Controllers;

use Zemit\Mvc\Controller\Traits\Actions\ErrorActions;
use Zemit\Mvc\Controller\Traits\StatusCode;

class ErrorController extends AbstractController
{
    use StatusCode;
    use ErrorActions;
}
