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
 * Class Json
 *
 * @package Zemit\Filters
 */
class Json
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function filter($value)
    {
        try {
            $before = json_decode($value);
            $valid = empty($before)? false : true;
        } catch (\Exception $e) {
            $valid = false;
        }
        
        return $valid? $value : null;
    }
}
