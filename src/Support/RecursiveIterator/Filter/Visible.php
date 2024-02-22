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

class Visible extends \RecursiveFilterIterator
{
    public function accept(): bool
    {
        $fileName = $this->getInnerIterator()->current()->getFileName();
        $firstChar = $fileName[0];
        return $firstChar !== '.';
    }
}
