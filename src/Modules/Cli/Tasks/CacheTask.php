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

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Zemit\Modules\Cli\Tasks\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\Cache
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class CacheTask extends AbstractTask
{
    protected $excludeFileNames = [
        '.',
        '..',
        '.gitkeep',
        '.gitignore',
    ];

    /**
     * @Doc("Clearing the application cache")
     */
    public function clear()
    {
        $this->output('Start');

        $this->output('Clear file cache...');
        $this->clearFileCache();

        $this->output('Clear models cache...');
        $this->clearCache('modelsCache');

        $this->output('Clear view cache...');
        $this->clearCache('viewCache');

        $this->output('Clear annotations cache...');
        $this->clearCache('annotations');

        $this->output('Done');
    }

    protected function clearFileCache()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(cache_path()),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $entry) {
            if ($entry->isDir() || in_array($entry->getBasename(), $this->excludeFileNames)) {
                continue;
            }

            unlink($entry->getPathname());
        }
    }

    protected function clearCache($service)
    {
        if (!container()->has($service)) {
            return;
        }

        $service = container($service);

        $service->flush();
    }
}
