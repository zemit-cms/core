<?php

namespace Zemit\Core;

use Phalcon\Debug as PhDebug;
use Phalcon\Di;

class Debug extends PhDebug
{
    public function getVersion() {
        $version = Di::getDefault()->get('config')->core->version;
        return parent::getVersion() . '<div class=\'version\'>Zemit CMS <a href="https://docs.zemit.com/en/'.$version.'/" target="_new">'.$version.'</a></div>';
    }
}