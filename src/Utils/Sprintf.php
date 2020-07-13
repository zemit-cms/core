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

//@TODO test & use
class Sprintf
{
    public static function implodeArrayMapSprintf($array = array(), $implode = ' ', $sprintf = '%s')
    {
        return implode($implode, array_map(function ($value, $key) use ($sprintf) {
            return self::mb_sprintf($sprintf, $value, $key);
        }, $array, array_keys($array)));
    }
    
    /**
     * version of sprintf for cases where named arguments are desired (php syntax)
     *
     * with sprintf: sprintf('second: %2$s ; first: %1$s', '1st', '2nd');
     *
     * with sprintfn: sprintfn('second: %second$s ; first: %first$s', array(
     *  'first' => '1st',
     *  'second'=> '2nd'
     * ));
     *
     * @param string $format sprintf format string, with any number of named arguments
     * @param array $args array of [ 'arg_name' => 'arg value', ... ] replacements to be made
     * @return string|false result of sprintf call, or bool false on error
     */
    public static function sprintfn($format, $args = array())
    {
        if (!is_array($args)) {
            if (is_object($args)) {
                $args = (array)$args;
            }
        }
        // map of argument names to their corresponding sprintf numeric argument value
//        $arg_nums = array_slice(array_flip(array_keys(array(0 => 0) + $args)), 1);
        $arg_nums = array_keys($args);
        array_unshift($arg_nums, 0);
        $arg_nums = array_flip(array_slice($arg_nums, 1, null, true));
        
        // find the next named argument. each search starts at the end of the previous replacement.
        for ($pos = 0; preg_match('/(?<=%)([a-zA-Z_]\w*)(?=\$)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
            $arg_pos = $match[0][1];
            $arg_len = strlen($match[0][0]);
            $arg_key = $match[1][0];
            
            // programmer did not supply a value for the named argument found in the format string
            if (! array_key_exists($arg_key, $arg_nums)) {
                user_error("sprintfn(): Missing argument '${arg_key}'", E_USER_WARNING);
                return false;
            }
            
            // replace the named argument with the corresponding numeric one
            $format = substr_replace($format, $replace = $arg_nums[$arg_key], $arg_pos, $arg_len);
            $pos = $arg_pos + strlen($replace); // skip to end of replacement for next iteration
        }
        
        return vsprintf($format, array_values($args));
    }
    
    /**
     * Return a formatted multibyte string
     * A more complete and working version of mb_sprintf and mb_vsprintf.
     * It should work with any "ASCII preserving" encoding such as UTF-8 and all the ISO-8859 charsets.
     * It handles sign, padding, alignment, width and precision. Argument swapping is not handled.
     * @link http://php.net/manual/en/function.sprintf.php#89020
     *
     * @param string $format <p>
     * The format string is composed of zero or more directives:
     * ordinary characters (excluding %) that are
     * copied directly to the result, and conversion
     * specifications, each of which results in fetching its
     * own parameter. This applies to both sprintf
     * and printf.
     * </p>
     * <p>
     * Each conversion specification consists of a percent sign
     * (%), followed by one or more of these
     * elements, in order:
     * An optional sign specifier that forces a sign
     * (- or +) to be used on a number. By default, only the - sign is used
     * on a number if it's negative. This specifier forces positive numbers
     * to have the + sign attached as well, and was added in PHP 4.3.0.
     * @param mixed $args [optional] <p>
     * </p>
     * @param mixed $_ [optional]
     *
     * @return string a string produced according to the formatting string
     * format.
     */
    public static function mb_sprintf($format, $args = null, $_ = null)
    {
        $argv = func_get_args();
        array_shift($argv);
        return self::mb_vsprintf($format, $argv);
    }
    
    /**
     * Return a formatted string
     * A more complete and working version of mb_sprintf and mb_vsprintf.
     * It should work with any "ASCII preserving" encoding such as UTF-8 and all the ISO-8859 charsets.
     * It handles sign, padding, alignment, width and precision. Argument swapping is not handled.
     * Works with all encodings in format and arguments.
     * Supported: Sign, padding, alignment, width and precision.
     * Not supported: Argument swapping.
     * @link http://php.net/manual/en/function.sprintf.php#89020
     *
     * @param string $format <p>
     * See sprintf for a description of
     * format.
     * </p>
     * @param array $args <p>
     * </p>
     *
     * @return string Return array values as a formatted string according to
     * format (which is described in the documentation
     * for sprintf).
     */
    public static function mb_vsprintf($format, $argv, $encoding = null)
    {
        if (!is_array($argv)) {
            $argv = array($argv);
        }
        
        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        
        // Use UTF-8 in the format so we can use the u flag in preg_split
        $format = mb_convert_encoding($format, 'UTF-8', $encoding);
        
        $newformat = ""; // build a new format in UTF-8
        $newargv = array(); // unhandled args in unchanged encoding
        
        while ($format !== "") {
            // Split the format in two parts: $pre and $post by the first %-directive
            // We get also the matched groups
            @list ($pre, $sign, $filler, $align, $size, $precision, $type, $post) =
                preg_split(
                    "!\%(\+?)('.|[0 ]|)(-?)([1-9][0-9]*|)(\.[1-9][0-9]*|)([%a-zA-Z])!u",
                    $format,
                    2,
                    PREG_SPLIT_DELIM_CAPTURE
                );
            
            $newformat .= mb_convert_encoding($pre, $encoding, 'UTF-8');
            
            if ($type == '') {
                // didn't match. do nothing. this is the last iteration.
            } elseif ($type == '%') {
                // an escaped %
                $newformat .= '%%';
            } elseif ($type == 's') {
                $arg = array_shift($argv);
                $arg = mb_convert_encoding($arg, 'UTF-8', $encoding);
                $padding_pre = '';
                $padding_post = '';
                
                // truncate $arg
                if ($precision !== '') {
                    $precision = intval(substr($precision, 1));
                    if ($precision > 0 && mb_strlen($arg, $encoding) > $precision) {
                        $arg = mb_substr($precision, 0, $precision, $encoding);
                    }
                }
                
                // define padding
                if ($size > 0) {
                    $arglen = mb_strlen($arg, $encoding);
                    if ($arglen < $size) {
                        if ($filler === '') {
                            $filler = ' ';
                        }
                        if ($align == '-') {
                            $padding_post = str_repeat($filler, $size - $arglen);
                        } else {
                            $padding_pre = str_repeat($filler, $size - $arglen);
                        }
                    }
                }
                
                // escape % and pass it forward
                $newformat .= $padding_pre . str_replace('%', '%%', $arg) . $padding_post;
            } else {
                // another type, pass forward
                $newformat .= "%$sign$filler$align$size$precision$type";
                $newargv[] = array_shift($argv);
            }
            $format = strval($post);
        }
        // Convert new format back from UTF-8 to the original encoding
        $newformat = mb_convert_encoding($newformat, $encoding, 'UTF-8');
        return !empty($newargv)? vsprintf($newformat, $newargv) : $newformat;
    }
}
