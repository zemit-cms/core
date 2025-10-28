<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Dispatcher\Exception;
use Zemit\Modules\Cli\Task;

class HelpTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli help cache
  zemit cli help cron
  zemit cli help database
  zemit cli help data-life-cycle
  zemit cli help scaffold
  zemit cli help test
  zemit cli help user

DOC;
    
    /**
     * Build Action
     *
     * This method executes the build action by forwarding the request to the build task's help action.
     *
     * @return void
     * @throws Exception if there is an error during the forwarding process
     */
    public function buildAction(): void
    {
        $this->dispatcher->forward(['task' => 'build', 'action' => 'help']);
    }
    
    /**
     * Cron Action
     *
     * This method executes the cron action by forwarding the request to the cron task's help action.
     *
     * @return void
     * @throws Exception if there is an error during the forwarding process
     */
    public function cronAction(): void
    {
        $this->dispatcher->forward(['task' => 'cron', 'action' => 'help']);
    }
    
    /**
     * Cache Action
     *
     * This method executes the cache action by forwarding the request to the cache task's help action.
     *
     * @return void
     * @throws Exception if there is an error during the forwarding process
     */
    public function cacheAction(): void
    {
        $this->dispatcher->forward(['task' => 'cache', 'action' => 'help']);
    }
}
