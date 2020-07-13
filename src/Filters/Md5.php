<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Filters;

/**
 * Class Md5
 *
 * @package Zemit\Filters
 */
class Md5
{
    /**
     * @param $value
     *
     * @return string|string[]|null
     */
    public function filter($value)
    {
        return preg_replace('/[^0-9a-f]/', null, $value);
    }
}
