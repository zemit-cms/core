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
use Zemit\Http\StatusCode;
use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Controller\Errors;

class ErrorTask extends Task
{
    use Errors;
    
    #[NoReturn]
    public function setStatusCode(?int $code = 500, ?string $message = null): ResponseInterface
    {
        echo 'Error: ' . $code . ' - ' . StatusCode::getMessage($code);
        exit(1);
    }
}
