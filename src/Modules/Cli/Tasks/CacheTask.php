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

class CacheTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli cache <action> [<params> ...]

Options:
  task: cache
  action: clear


DOC;
}
