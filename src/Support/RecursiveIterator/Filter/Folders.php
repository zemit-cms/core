<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\RecursiveIterator\Filter;

class Folders extends \RecursiveFilterIterator
{
    public function accept(): bool
    {
        $iterator = $this->getInnerIterator();
        
        // allow traversal
        if ($iterator->hasChildren()) {
            return true;
        }
        
        // filter entries, only allow true folders
        return !$iterator->current()->isFile();
    }
}
