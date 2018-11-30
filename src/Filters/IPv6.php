<?php

namespace Zemit\Core\Filters;

class IPv6
{
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
    
}