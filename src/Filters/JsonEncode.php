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
        return json_encode($value);
    }
    
}