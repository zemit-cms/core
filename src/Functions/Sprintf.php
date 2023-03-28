<?php

if (!function_exists('implode_sprintf')) {
    /**
     * Will implode an array_map return of the sprintf or mb_sprintf results
     */
    function implode_sprintf(array $array = [], string $glue = ' ', string $format = '%s', $multibyte = false): string
    {
        return implode($glue, array_map(function ($value, $key) use ($format, $multibyte) {
            return $multibyte
                ? mb_sprintf($format, $value, $key)
                : sprintf($format, $value, $key);
        }, $array, array_keys($array)));
    }
}

if (!function_exists('implode_mb_sprintf')) {
    /**
     * Will implode an array_map return of the mb_sprintf results
     */
    function implode_mb_sprintf(array $array = [], string $glue = ' ', string $format = '%s'): string
    {
        return implode_sprintf($array, $glue, $format, true);
    }
}

if (!function_exists('sprintfn')) {
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
    function sprintfn(string $format, array $args = [])
    {
        // map of argument names to their corresponding sprintf numeric argument value
        $array = array_keys($args);
        array_unshift($array, 0);
        $array = array_flip(array_slice($array, 1, null, true));
        
        // find the next named argument. each search starts at the end of the previous replacement.
        for ($pos = 0; preg_match('/(?<=%)([a-zA-Z_]\w*)(?=\$)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
            $position = intval($match[0][1]);
            $length = strlen($match[0][0]);
            $key = $match[1][0];
            
            // programmer did not supply a value for the named argument found in the format string
            if (!array_key_exists($key, $array)) {
                user_error("sprintfn(): Missing argument '${$key}'", E_USER_WARNING);
                return false;
            }
            
            // replace the named argument with the corresponding numeric one
            $format = substr_replace($format, $replace = $array[$key], $position, $length);
            $pos = $position + strlen($replace);
            
            // skip to end of replacement for next iteration
        }
        
        return vsprintf($format, array_values($args));
    }
}

if (!function_exists('mb_sprintf')) {
    /**
     * Return a formatted multibyte string
     * A more complete and working version of mb_sprintf and mb_vsprintf.
     * It should work with any "ASCII preserving" encoding such as UTF-8 and all the ISO-8859 charsets.
     * It handles sign, padding, alignment, width and precision. Argument swapping is not handled.
     * @link http://php.net/manual/en/function.sprintf.php#89020
     */
    function mb_sprintf($format, ...$args): string
    {
        return mb_vsprintf($format, $args);
    }
}

if (!function_exists('mb_vsprintf')) {
    /**
     * Return a formatted string
     * It should work with any "ASCII preserving" encoding such as UTF-8 and all the ISO-8859 charsets.
     * It handles sign, padding, alignment, width and precision. Argument swapping is not handled.
     * Works with all encodings in format and arguments.
     * Supported: Sign, padding, alignment, width and precision.
     * Not supported: Argument swapping.
     * @link http://php.net/manual/en/function.sprintf.php#89020
     */
    function mb_vsprintf($format, $argv, $encoding = null): string
    {
        if (!is_array($argv)) {
            $argv = [$argv];
        }
        
        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        
        // Use UTF-8 in the format so we can use the u flag in preg_split
        $format = mb_convert_encoding($format, 'UTF-8', $encoding);
        $newFormat = '';
        
        // build a new format in UTF-8
        $newArgv = [];
        
        // unhandled args in unchanged encoding
        while ($format !== '') {
            
            // Split the format in two parts: $pre and $post by the first %-directive
            // We get also the matched groups
            $split = preg_split("!\%(\+?)('.|[0 ]|)(-?)([1-9][0-9]*|)(\.[1-9][0-9]*|)([%a-zA-Z])!u", $format, 2, PREG_SPLIT_DELIM_CAPTURE);
            $pre = $split[0] ?? null;
            $sign = $split[1] ?? null;
            $filler = $split[2] ?? null;
            $align = $split[3] ?? null;
            $size = $split[4] ?? null;
            $precision = $split[5] ?? null;
            $type = $split[6] ?? null;
            $post = $split[7] ?? null;
            
            $newFormat .= mb_convert_encoding($pre, $encoding, 'UTF-8');
            
            if ($type === '') {
                // didn't match. do nothing. this is the last iteration.
            }
            elseif ($type === '%') {
                // an escaped %
                $newFormat .= '%%';
            }
            elseif ($type === 's') {
                $arg = array_shift($argv);
                $arg = mb_convert_encoding($arg, 'UTF-8', $encoding);
                $paddingPre = '';
                $paddingPost = '';
                
                // truncate $arg
                if ($precision !== '') {
                    $precision = intval(substr($precision, 1));
                    if ($precision > 0 && mb_strlen($arg, $encoding) > $precision) {
                        $arg = mb_substr($precision, 0, $precision, $encoding);
                    }
                }
                
                // define padding
                if ($size > 0) {
                    $argLength = mb_strlen($arg, $encoding);
                    if ($argLength < $size) {
                        if ($filler === '') {
                            $filler = ' ';
                        }
                        if ($align === '-') {
                            $paddingPost = str_repeat($filler, $size - $argLength);
                        }
                        else {
                            $paddingPre = str_repeat($filler, $size - $argLength);
                        }
                    }
                }
                
                // escape % and pass it forward
                $newFormat .= $paddingPre . str_replace('%', '%%', $arg) . $paddingPost;
            }
            else {
                // another type, pass forward
                $newFormat .= "%$sign$filler$align$size$precision$type";
                $newArgv[] = array_shift($argv);
            }
            
            $format = strval($post);
        }
        // Convert new format back from UTF-8 to the original encoding
        $newFormat = mb_convert_encoding($newFormat, $encoding, 'UTF-8');
        return !empty($newArgv) ? vsprintf($newFormat, $newArgv) : $newFormat;
    }
}
