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

namespace PhalconKit\Modules\Cli\Tasks;

use Phalcon\Http\ResponseInterface;
use PhalconKit\Exception\CliException;
use PhalconKit\Http\StatusCode;
use PhalconKit\Modules\Cli\Task;
use PhalconKit\Mvc\Controller\Traits\Actions\ErrorActions;

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
    #[\Override]
    public function setStatusCode(int $code = 500, ?string $message = null): ResponseInterface
    {
        $message ??= StatusCode::getMessage($code);
        throw new CliException('Error: ' . $code . ' - ' . $message);
    }
}
