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

use JetBrains\PhpStorm\NoReturn;
use Phalcon\Http\ResponseInterface;
use Zemit\Exception\CliException;
use Zemit\Http\StatusCode;
use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Controller\Errors;

class ErrorTask extends Task
{
    use Errors;
    
    /**
     * @param int|null $code The status code to set. Defaults to 500 if not provided.
     * @param string|null $message The status message to set. Defaults to null if not provided.
     * @return ResponseInterface The response object.
     * @throws CliException
     */
    #[NoReturn]
    public function setStatusCode(?int $code = 500, ?string $message = null): ResponseInterface
    {
        throw new CliException('Error: ' . $code . ' - ' . StatusCode::getMessage($code));
    }
}
