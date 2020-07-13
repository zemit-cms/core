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

class Escaper extends \Phalcon\Escaper
{
    
    /**
     * Execute the rawurlencode function on the json string
     * Will also encode the parameter in json format if the passed
     * parameter is not a valid json
     *
     * Frontend JS side must:
     * JSON.parse(decodeURIComponent('<?= $this->escaper->escapeJson([]);?>'));
     *
     * @param mixed|string $json Json string or anything else
     * @return string
     */
    public function escapeJson($json = null)
    {
        
        // if it's a not empty string
        if (is_string($json) && !empty($json)) {
            // check if it's a valid json
            $ret = (new Filters\Json())->filter($json);
        }
    
        // not a valid json, encode it, yolo
        if (empty($ret)) {
            $ret = json_encode($json);
        }
    
        // rawurlencode trick
        $ret = rawurlencode($ret);
        
        return $ret;
    }
}
