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
 * Class CronTask
 * @package Zemit\Modules\Cli\Tasks
 */
class CronTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli cron <action> [<params> ...]

Options:
  task: cron
  action: main,hourly,daily,weekly,monthly


DOC;
    
    public function helpAction() {
        echo $this->consoleDoc;
    }
    
    public function mainAction() {
    
    }
    
    public function hourlyAction() {
    
    }
    
    public function dailyAction() {
    
    }
    
    public function weeklyAction() {
    
    }
    
    public function monthlyAction() {
    
    }
}