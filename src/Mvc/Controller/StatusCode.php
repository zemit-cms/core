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

use Phalcon\Http\ResponseInterface;

/**
 * Mostly designed for Error Controllers
 */
trait StatusCode
{
    /**
     * Set the status code to the response
     */
    public function setStatusCode(int $code = 200, ?string $message = null): ResponseInterface
    {
        $message ??= \Zemit\Http\StatusCode::getMessage($code);
        return $this->response->setStatusCode($code, $message);
    }
}
