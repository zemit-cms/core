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

use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Controller\StatusCode;

/**
 * Class ErrorsTask
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class ErrorTask extends Task
{
    use StatusCode;
    
    public function setStatusCode($code)
    {
        echo 'Error: ' . $code . ' - ' . \Zemit\Http\StatusCode::getMessage($code);
        exit(PHP_EOL);
    }
}
