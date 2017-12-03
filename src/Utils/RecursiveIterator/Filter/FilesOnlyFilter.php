<?php

namespace Zemit\Core\Plugins\Utils\RecursiveIterator\Filter;

class FilesOnlyFilter extends \RecursiveFilterIterator {

    public function accept() {
        $iterator = $this->getInnerIterator();

        // allow traversal
        if ($iterator->hasChildren()) {
            return true;
        }

        // filter entries, only allow true files
        return $iterator->current()->isFile();
    }
}