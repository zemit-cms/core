<?php

namespace Zemit\Core;

use Phalcon\Escaper as PhalconEscaper;

class Escaper extends PhalconEscaper
{
    
    /**
     * Execute the rawurlencode function on the json string
     * Will also encode the parameter in json format if the passed
     * parameter is not a string
     *
     * @TODO validate if its a valid json string instead
     *
     * @param $json
     * @return string
     */
    public function escapeJson($json = null) {
        $ret = null;
        if (!empty($json)) {
            if (!is_string($json)) {
                $ret = json_encode($json);
            }
            $ret = rawurlencode($ret);
        }
        return $ret;
    }
}