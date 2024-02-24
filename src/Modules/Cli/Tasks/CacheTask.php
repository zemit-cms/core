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

use Phalcon\Cache\Exception\InvalidArgumentException;
use Zemit\Modules\Cli\Task;

class CacheTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli cache clear
  zemit cli cache has <key>
  zemit cli cache delete <key>
  zemit cli cache delete-multiple [<key>...]

DOC;
    
    /**
     * Clears all items from the cache.
     *
     * @return bool True if all items were successfully cleared, false otherwise.
     */
    public function clearAction(): bool
    {
        return $this->cache->clear();
    }
    
    /**
     * Checks if the given action key exists in the cache.
     *
     * @param string $key The key identifying the action in the cache.
     * @return bool Returns true if the action key exists in the cache, false otherwise.
     * @throws InvalidArgumentException
     */
    public function hasAction(string $key): bool
    {
        return $this->cache->has($key);
    }
    
    /**
     * Deletes an item from the cache.
     *
     * @param string $key The key of the item to be deleted.
     * @return bool True if the item was successfully deleted, false otherwise.
     * @throws InvalidArgumentException
     */
    public function deleteAction(string $key): bool
    {
        return $this->cache->delete($key);
    }
    
    /**
     * Deletes multiple cache entries specified by the given keys.
     *
     * @param mixed ...$keys A variable number of keys representing the cache entries to be deleted.
     *
     * @return bool Returns true if all cache entries were successfully deleted, false otherwise.
     */
    public function deleteMultipleAction(string ...$keys): bool
    {
        return $this->cache->deleteMultiple($keys);
    }
}
