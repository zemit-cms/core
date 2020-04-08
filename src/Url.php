<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

/**
 * Class Url
 * @package Zemit\Mvc
 */
class Url extends \Phalcon\Url
{
    
    /**
     * {@inheritdoc}
     *
     * @param null $uri
     * @param null $args
     * @param bool|null $local
     * @param null $baseUri
     *
     * @return string
     */
    public function get($uri = null, $args = null, bool $local = null, $baseUri = null): string {
        return self::getAbsolutePath(parent::get($uri, $args, $local, $baseUri));
    }
    
    /**
     * @param string $path
     *
     * @return string
     */
    public static function getAbsolutePath(string $path) : string {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'mb_strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' === $part) {
                continue;
            }
            if ('..' === $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return '/' . implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}
