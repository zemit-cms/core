<?php

namespace Zemit\Core\Filters;

class Md5
{
    public function filter($value)
    {
        return preg_replace('/[^0-9a-f]/', null, $value);
    }
    
}