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
 * Class BuildTask
 * @package Zemit\Modules\Cli\Tasks
 */
class BuildTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli build <action> [<params> ...]

Options:
  task: build
  action: main


DOC;
}
