<?php

namespace Zemit\Modules\Cli;

use Phalcon\Cli\Task as PhalconTask;

class Task extends PhalconTask
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  zemit console <task> <action> [<params> ...]

Options:
  task: build,cron


DOC;
    
    public function helpAction() {
        echo $this->consoleDoc;
    }
    
    public function mainAction() {
        $this->helpAction();
    }
}