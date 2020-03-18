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
 * Zemit\Modules\Cli\Tasks\Version
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class VersionTask extends AbstractTask
{
    /**
     * @Doc("Getting the application version")
     */
    public function main()
    {
        $sha = $this->getCommitSha();
        if (!empty($sha)) {
            $sha = ', git commit ' . substr($sha, 0, 7);
        }

        $this->output(
            sprintf(
                '%s version %s%s',
                container('app')->getName(),
                container('app')->getVersion(),
                $sha
            )
        );
    }

    protected function getCommitSha()
    {
        $gitDir = $this->basePath . DIRECTORY_SEPARATOR . '.git';

        if (!file_exists($gitDir) || !$this->isShellCommandExist('git')) {
            return '';
        }

        return implode(' ', $this->runShellCommand('git rev-parse HEAD', false));
    }
}
