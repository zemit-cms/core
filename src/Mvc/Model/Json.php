<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

trait Json
{
    /**
     * JSON Encode or fallback to value
     * @see json_encode
     */
    public function jsonEncode($value, int $flags = JSON_UNESCAPED_SLASHES, int $depth = 512)
    {
        return json_encode($value, $flags, $depth) ?: $value;
    }
    
    /**
     * JSON Decode or fallback to value
     * @see json_decode
     */
    public function jsonDecode(string $json, ?bool $associative = null, int $depth = 512, int $flags = 0)
    {
        return json_decode($json, $associative, $depth, $flags) ?: $json;
    }
}
