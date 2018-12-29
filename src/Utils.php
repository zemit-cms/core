<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

class Utils
{
    public static function getNamespace($class) {
        return substr(get_class($class), 0, strrpos(get_class($class), "\\"));
    }
}