<?php

namespace Zemit\Core\Cli\Tasks;

use Zemit\Core\Cli\Task;

class BuildTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  zemit console build <action> [<params> ...]

Options:
  task: build
  action: main


DOC;
}