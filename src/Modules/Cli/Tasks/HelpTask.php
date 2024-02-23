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

use Phalcon\Exception;
use Zemit\Modules\Cli\Task;

class HelpTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli <task> [<action>] [<params> ...]

Options:
  task: build,cron,cache


DOC;
    
    /**
     * @throws Exception
     */
    public function buildAction(): void
    {
        $this->dispatcher->forward(['task' => 'build', 'action' => 'help']);
    }
    
    /**
     * @throws Exception
     */
    public function cronAction(): void
    {
        $this->dispatcher->forward(['task' => 'cron', 'action' => 'help']);
    }
    
    /**
     * @throws Exception
     */
    public function cacheAction(): void
    {
        $this->dispatcher->forward(['task' => 'cache', 'action' => 'help']);
    }
}
