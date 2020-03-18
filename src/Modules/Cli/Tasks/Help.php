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

use Zemit\Console\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\Help
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class HelpTask extends AbstractTask
{
    /**
     * @Doc("Getting the application help")
     */
    public function main()
    {
        $this->output(sprintf('%s %s', container('app')->getName(), container('app')->getVersion()));
        $this->output('Usage: php forum [command <arguments>] [--help | -H] [--version | -V] [--list]');
    }
}
