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

class BuildTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli build <action> [<params> ...]

Options:
  task: build
  action: main


DOC;
}
