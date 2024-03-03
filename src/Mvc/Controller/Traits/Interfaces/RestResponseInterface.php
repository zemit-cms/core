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

interface RestResponseInterface
{
    public function setRestErrorResponse(int $code = 400, string $status = 'Bad Request', mixed $response = null): ResponseInterface;
    
    public function setRestResponse(mixed $response = null, int $code = null, string $status = null, int $jsonOptions = 0, int $depth = 512): ResponseInterface;
}
