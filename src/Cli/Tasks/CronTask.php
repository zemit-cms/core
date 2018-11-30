<?php

namespace Zemit\Core\Cli\Tasks;

use Zemit\Core\Cli\Task;

class CronTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  zemit console cron <action> [<params> ...]

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