<?php
declare(strict_types=1);
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

/**
 * Trait Json
 *
 * This trait provides methods for encoding and decoding JSON data.
 */
trait Json
{
    /**
     * Encodes a value to JSON.
     *
     * @param mixed $value The value to be encoded.
     * @param int $flags [Optional] Bitmask of JSON encode options.
     *                              Defaults to JSON_UNESCAPED_SLASHES.
     * @param int $depth [Optional] The maximum depth of recursion when encoding nested objects.
     *                              Defaults to 512.
     *
     * @return string|false The JSON encoded string on success, or `false` on failure.
     */
    public function jsonEncode(mixed $value, int $flags = JSON_UNESCAPED_SLASHES, int $depth = 512): string|false
    {
        return json_encode($value, $flags, $depth);
    }
    
    /**
     * Decodes a JSON string.
     *
     * @param string $json The JSON string to be decoded.
     * @param bool|null $associative [Optional] When `true`, returned objects will be converted into associative arrays.
     *                                         When `false`, objects will be returned as generic objects. If `null`, objects
     *                                         will be returned based on the JSON_NUMERIC_CHECK flag.
     * @param int $depth [Optional] The maximum depth of recursion when decoding nested objects.
     *                              Defaults to 512.
     * @param int $flags [Optional] Bitmask of JSON decode options.
     *                              Defaults to 0.
     *
     * @return mixed The decoded value on success, or the original JSON string on failure.
     */
    public function jsonDecode(string $json, ?bool $associative = null, int $depth = 512, int $flags = 0): mixed
    {
        return json_decode($json, $associative, $depth, $flags);
    }
}
