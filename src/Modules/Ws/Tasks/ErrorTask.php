<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Ws\Tasks;

use Phalcon\Http\ResponseInterface;
use Zemit\Exception\WsException;
use Zemit\Http\StatusCode;
use Zemit\Modules\Ws\Task;
use Zemit\Mvc\Controller\Traits\Actions\ErrorActions;

class ErrorTask extends Task
{
    use ErrorActions;
    
    /**
     * Set the status code for the response. Immediately throw a CliException.
     *
     * @param int $code The status code to set. Defaults to 500 if not provided.
     * @param string|null $message The optional message to associate with the status code.
     *
     * @throws WsException If an error occurs while setting the status code.
     */
    #[\Override]
    public function setStatusCode(int $code = 500, ?string $message = null): ResponseInterface
    {
        $message ??= StatusCode::getMessage($code);
        throw new WsException('Error: ' . $code . ' - ' . $message);
    }
}
