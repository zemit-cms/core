<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Utils;

use Transliterator;
use Zemit\Exception;

/**
 * Class Slug
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Utils
 */
class Slug
{
    /**
     * Creates a slug to be used for pretty URLs.
     *
     * @param  string $string
     * @param  array  $replace
     * @param  string $delimiter
     * @return string
     *
     * @throws Exception
     */
    public static function generate($string, $replace = [], $delimiter = '-')
    {
        if (!extension_loaded('intl')) {
            throw new Exception('intl module not loaded');
        }
        if (!extension_loaded('mbstring')) {
            throw new Exception('mbstring module not loaded');
        }
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        // Better to replace given $replace array as index => value
        // Example $replace['ı' => 'i', 'İ' => 'i'];
        if (!empty($replace) && is_array($replace)) {
            $string = str_replace(array_keys($replace), array_values($replace), $string);
        }
        $transliterator = Transliterator::create('Any-Latin; Latin-ASCII');
        $string = $transliterator->transliterate(
            mb_convert_encoding(htmlspecialchars_decode($string), 'UTF-8', 'auto')
        );
        self::restoreLocale($oldLocale);
        return self::cleanString($string, $delimiter);
    }
    /**
     * Revert back to the old locale
     */
    protected static function restoreLocale($oldLocale)
    {
        if ((stripos($oldLocale, '=') > 0)) {
            parse_str(str_replace(';', '&', $oldLocale), $loc);
            $oldLocale = array_values($loc);
        }
        setlocale(LC_ALL, $oldLocale);
    }
    protected static function cleanString($string, $delimiter)
    {
        // replace non letter or non digits by -
        $string = preg_replace('#[^\pL\d]+#u', '-', $string);
        // Trim trailing -
        $string = trim($string, '-');
        $clean = preg_replace('~[^-\w]+~', '', $string);
        $clean = strtolower($clean);
        $clean = preg_replace('#[\/_|+ -]+#', $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        return $clean;
    }
}
