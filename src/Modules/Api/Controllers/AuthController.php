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

namespace PhalconKit\Modules\Api\Controllers;

use PhalconKit\Mvc\Controller\Rest;
use PhalconKit\Mvc\Controller\Traits\Actions\AuthActions;

class AuthController extends Rest
{
    use AuthActions;
}
