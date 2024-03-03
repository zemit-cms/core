<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Http\ResponseInterface;
use Zemit\Exception\CliException;
use Zemit\Http\StatusCode;
use Zemit\Modules\Cli\Task;
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
     * @throws CliException If an error occurs while setting the status code.
     */
    public function setStatusCode(int $code = 500, ?string $message = null): ResponseInterface
    {
        $message ??= StatusCode::getMessage($code);
        throw new CliException('Error: ' . $code . ' - ' . $message);
    }
}
