<?php

namespace Zemit\Core;

use Phalcon\Filter as PhalconFilter;

class Filter extends PhalconFilter
{
    const FILTER_JSON = "json";
    
    public function __construct()
    {
        $this->add(self::FILTER_JSON, new Filters\Json());
    }
    
}