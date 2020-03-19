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

/**
 * Class HelpTask
 * @package Zemit\Modules\Cli\Tasks
 */
class HelpTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli <task> [<action>] [<params> ...]

Options:
  task: build,cron


DOC;
    
    public function buildAction() {
        $this->dispatcher->forward(['task' => 'build', 'action' => 'help']);
    }
    
    public function CronAction() {
        $this->dispatcher->forward(['task' => 'cron', 'action' => 'help']);
    }
}