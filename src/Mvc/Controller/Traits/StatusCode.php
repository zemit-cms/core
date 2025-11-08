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

namespace PhalconKit\Mvc\Controller\Traits;

use Phalcon\Http\ResponseInterface;
use PhalconKit\Mvc\Controller\Traits\Abstracts\AbstractStatusCode;

/**
 * Set the status code to the response
 */
trait StatusCode
{
    use AbstractStatusCode;
    
    /**
     * Sets the status code and message for a response.
     *
     * @param int $code The HTTP status code to set. Default is 200.
     * @param string|null $message The optional message for the status code. If not provided, the default message
     *                             associated with the provided status code will be used.
     * @return ResponseInterface The updated response object.
     */
    public function setStatusCode(int $code = 200, ?string $message = null): ResponseInterface
    {
        $message ??= \PhalconKit\Http\StatusCode::getMessage($code);
        return $this->response->setStatusCode($code, $message);
    }
}
