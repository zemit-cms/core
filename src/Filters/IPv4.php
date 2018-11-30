<?php

namespace Zemit\Core\Filters;

class IPv4
{
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    
}