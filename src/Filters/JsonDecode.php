<?php

namespace Zemit\Core\Filters;

class JsonDecode
{
    /**
     * @param $value
     * @return null or the valid json string
     */
    public function filter($value)
    {
        try {
            $before = json_decode($value, true);
            $valid = empty($before)? false : true;
        } catch(\Exception $e) {
            $valid = false;
        }
        return $valid? $before : null;
    }
    
}