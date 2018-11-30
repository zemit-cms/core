<?php

namespace Zemit\Core\Mvc;

class Url extends \Phalcon\Mvc\Url
{
    public function get($uri = null, $args = null, $local = null, $baseUri = null)
    {
        return self::getAbsolutePath(parent::get($uri, $args, $local, $baseUri));
    }
    
    public static function getAbsolutePath($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'mb_strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return '/' . implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}