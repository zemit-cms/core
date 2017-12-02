<?php

namespace Zemit\Plugins\Utils\RecursiveIterator\Filter;

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
