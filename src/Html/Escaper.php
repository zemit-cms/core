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

use Zemit\Html\Escaper\EscaperInterface;

/**
 * Zemit\Html\Escaper
 *
 * Escapes different kinds of text securing them. By using this component you
 * may prevent XSS attacks.
 *
 * This component only works with UTF-8. The PREG extension needs to be compiled
 * with UTF-8 support.
 *
 * ```php
 * $escaper = new \Phalcon\Html\Escaper();
 *
 * $escaped = $escaper->escapeCss("font-family: <Verdana>");
 *
 * echo $escaped; // font\2D family\3A \20 \3C Verdana\3E
 * ```
 */
class Escaper extends \Phalcon\Html\Escaper implements EscaperInterface
{
    /**
     * Escapes a JSON string by raw URL encoding it.
     *
     *  JS side could decode and parse this way:
     *  JSON.parse(decodeURIComponent('<?= $this->escaper->json([]);?>'));
     *
     * @param mixed|null $json The JSON string to escape. If null, an empty string is escaped.
     * @return string Returns the raw URL encoded JSON string.
     */
    #[\Override]
    public function json(mixed $json = null): string
    {
        if (is_null($json)) {
            return 'null';
        }
        
        // raw url encode
        return rawurlencode(json_validate($json) ? $json : json_encode($json));
    }
}
