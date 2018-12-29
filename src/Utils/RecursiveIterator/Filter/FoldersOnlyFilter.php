<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Utils\RecursiveIterator\Filter;

class FoldersOnlyFilter extends \RecursiveFilterIterator {

    public function accept() {
        $iterator = $this->getInnerIterator();

        // allow traversal
        if ($iterator->hasChildren()) {
            return true;
        }

        // filter entries, only allow true folders
        return !$iterator->current()->isFile();
    }
}
