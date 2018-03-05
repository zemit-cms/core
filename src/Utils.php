<?php

namespace Zemit\Core;

class Utils
{
    public static function getNamespace($class) {
        return substr(get_class($class), 0, strrpos(get_class($class), "\\"));
    }
}