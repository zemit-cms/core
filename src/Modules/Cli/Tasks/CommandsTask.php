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

use Zemit\Console\TaskFinder;
use Zemit\Console\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\Commands
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class CommandsTask extends AbstractTask
{
    /**
     * @Doc("Getting list of the console tasks")
     */
    public function main()
    {
        $finder = new TaskFinder(app_path('task'));
        $list   = $finder->scan();

        $this->output('');
        $this->output(sprintf('%s %s', container('app')->getName(), container('app')->getVersion()));
        $this->output('');

        $system = [];

        foreach ($list as $commands) {
            foreach ($commands as $command) {
                $name = $command['command'];
                if (!empty($command['name'])) {
                    $name .= ":{$command['name']}";
                }

                if (in_array($name, ['commands', 'help', 'version'])) {
                    $system[] = [
                        'name'        => $name,
                        'description' => $command['description'],
                    ];

                    continue;
                }

                $this->output(sprintf('% 22s         %s', $name, $command['description']));
            }
        }

        $this->output('');

        foreach ($system as $command) {
            $this->output(sprintf('% 22s         %s', $command['name'], $command['description']));
        }

        $this->output('');
    }
}
