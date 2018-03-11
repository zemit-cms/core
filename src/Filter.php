<?php

namespace Zemit\Core;

use Phalcon\Filter as PhalconFilter;

class Filter extends PhalconFilter
{
    const FILTER_JSON = "json";
    const FILTER_SERIALIZE = "serialize";
    
    public function __construct()
    {
        $this->add(self::FILTER_JSON, new Filters\Json());
        $this->add(self::FILTER_SERIALIZE, new Filters\Serialize());
        $this->add(self::FILTER_FRONTEND, new Filters\Frontend());
    }
    
}