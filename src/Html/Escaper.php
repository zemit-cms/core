<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Html;

/**
 * {@inheritDoc}
 */
class Escaper extends \Phalcon\Html\Escaper
{
    /**
     * Escapes a JSON string by raw URL encoding it.
     *
     *  JS side could decode and parse this way:
     *  JSON.parse(decodeURIComponent('<?= $this->escaper->escapeJson([]);?>'));
     *
     * @param mixed|null $json The JSON string to escape. If null, an empty string is escaped.
     * @return string Returns the raw URL encoded JSON string.
     */
    public function escapeJson(mixed $json = null): string
    {
        // raw url encode
        return rawurlencode(json_validate($json) ? $json ?? '' : json_encode($json));
    }
}
