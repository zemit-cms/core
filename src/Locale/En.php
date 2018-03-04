<?php

namespace Zemit\Core\Locale;

use Phalcon\Translate\Adapter\NativeArray;

class En extends NativeArray
{
    public function __construct(array $options)
    {
        $this->replacePlaceholders('zemit', [
            'zemit' => '<a href="https://www.zemit.com/">Zemit</a>'
        ]);
        
        parent::__construct(array_merge_recursive([
            'locale' => 'en_US.UTF-8',
            'defaultDomain' => 'zemit',
            'category' => LC_MESSAGES,
            'content' => [
                'powered-by' => 'Powered by %zemit%.',
                'copyright' => '%zemit% &copy; 2017 Zemit.',
            ],
        ], $options));
    }
    
}