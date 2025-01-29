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

use Zemit\Mvc\Controller\Rest;
use Zemit\Mvc\Controller\Traits\Actions\AuthActions;

class AuthController extends Rest
{
    use AuthActions;
}
