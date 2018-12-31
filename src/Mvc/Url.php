<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

/**
 * Class Url
 * @package Zemit\Mvc
 */
class Url extends \Phalcon\Mvc\Url
{
    public function get($uri = null, $args = null, bool $local = null, $baseUri = null): string {
        return self::getAbsolutePath(parent::get($uri, $args, $local, $baseUri));
    }
    
    public static function getAbsolutePath(string $path) : string {
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