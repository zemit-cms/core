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
 * Class IPv6
 *
 * @package Zemit\Filters
 */
class IPv6
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
}
