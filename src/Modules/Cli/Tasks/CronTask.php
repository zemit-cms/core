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

use Zemit\Modules\Cli\Task;

class CronTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli cron <action> [<params> ...]

Options:
  task: cron
  action: main,hourly,daily,weekly,monthly


DOC;

    #[\Override]
    public function mainAction(): ?array
    {
        return null;
    }

    public function hourlyAction(): ?array
    {
        return null;
    }

    public function dailyAction(): ?array
    {
        return null;
    }

    public function weeklyAction(): ?array
    {
        return null;
    }

    public function monthlyAction(): ?array
    {
        return null;
    }
}
