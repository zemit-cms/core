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
use Zemit\Utils;

/**
 * Class HelpTask
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class TestTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli <task> [<action>] [<params> ...]

Options:
  task: memory


DOC;
    
    public function memoryAction()
    {
        return Utils::getMemoryUsage();
    }
}
