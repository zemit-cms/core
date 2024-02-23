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
use Zemit\Modules\Cli\Tasks\Traits\UserTrait;

class UserTask extends Task
{
    use UserTrait;
    
    public string $cliDoc = <<<DOC
Usage:
  zemit cli user <action> [<params> ...]

Options:
  task: user
  action: create, password, role


DOC;
}
