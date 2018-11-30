<?php

namespace Zemit\Core\Filters;

class Json
{
    /**
     * @param $value
     * @return null or the valid json string
     */
    public function filter($value)
    {
        try {
            $before = json_decode($value);
            $valid = empty($before)? false : true;
        } catch(\Exception $e) {
            $valid = false;
        }
        return $valid? $value : null;
    }
    
}