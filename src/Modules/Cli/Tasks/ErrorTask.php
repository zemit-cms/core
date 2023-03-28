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

use Zemit\Http\StatusCode;
use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Controller\Errors;

class ErrorTask extends Task
{
    use Errors;
    
    public function setStatusCode(?int $code = 500): void
    {
        echo 'Error: ' . $code . ' - ' . StatusCode::getMessage($code);
        exit(1);
    }
}
