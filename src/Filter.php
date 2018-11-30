<?php

namespace Zemit\Core;

use Phalcon\Filter as PhalconFilter;

class Filter extends PhalconFilter
{
    const FILTER_MD5 = 'md5';
    const FILTER_JSON = 'json';
    const FILTER_IPV4 = 'ipv4';
    const FILTER_IPV6 = 'ipv6';
    
    public function __construct()
    {
        $this->add(self::FILTER_MD5, new Filters\Md5());
        $this->add(self::FILTER_JSON, new Filters\Json());
        $this->add(self::FILTER_IPV4, new Filters\IPv4());
        $this->add(self::FILTER_IPV6, new Filters\IPv6());
    }
    
}