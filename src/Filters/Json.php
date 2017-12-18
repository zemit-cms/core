<?php

namespace Zemit\Core\Filters;

class Json
{
    public function filter($value)
    {
        $valid = false;
        try {
            $before = json_decode($value);
            $valid = empty($before)? false : true;
        } catch(\Exception $e) {
            $valid = false;
        }
        return $valid? $value : null;
    }
    
}