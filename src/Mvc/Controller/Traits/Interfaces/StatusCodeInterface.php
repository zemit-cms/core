<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Interfaces;

use Phalcon\Http\ResponseInterface;

interface StatusCodeInterface
{
    public function setStatusCode(int $code = 200, ?string $message = null): ResponseInterface;
}
