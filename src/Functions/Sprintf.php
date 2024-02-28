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
    function sprintfn(string $format, array $args = []): false|string
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
                user_error("sprintfn(): Missing argument '{${$key}}'", E_USER_WARNING);
                return false;
            }
            
            // replace the named argument with the corresponding numeric one
            $format = (string)substr_replace($format, $replace = $array[$key], $position, $length);
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
    function mb_sprintf(string $format, ...$args): string
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
    function mb_vsprintf(string $format, array $argv, ?string $encoding = null): string
    {
        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        
        $format = (string)mb_convert_encoding($format, 'UTF-8', $encoding);
        $newFormat = '';
        $newArgv = [];
        
        while ($format !== '') {
            // Corrected regular expression pattern
            $split = preg_split("!(%[0-9]*\$)?%([-+ 0]|'.)?(-?[0-9]*)?(\.\d+)?([bcdeEfFgGosuxX])!u", $format, 2, PREG_SPLIT_DELIM_CAPTURE);
            
            if (empty($split) || count($split) < 7) {
                // If split is empty or does not contain all expected parts, append the rest of the format string as-is.
                $newFormat .= mb_convert_encoding($format, $encoding, 'UTF-8');
                break;
            }
            
            $pre = $split[0];
            $numberedArg = $split[1] ?? '';
            $sign = $split[2] ?? '';
            $size = $split[3] ?? '';
            $precision = $split[4] ?? '';
            $type = $split[5] ?? '';
            $post = $split[6] ?? '';
            
            $newFormat .= mb_convert_encoding($pre, $encoding, 'UTF-8');
            
            if ($type === '') {
                // Incomplete specifier at the end of the string, escape it.
                $newFormat .= '%';
            } elseif ($type === '%') {
                $newFormat .= '%%';
            } else {
                $newFormat .= "%$numberedArg$sign$size$precision$type";
                $newArgv[] = array_shift($argv);
            }
            
            $format = $post;
        }
        
        $newFormat = (string)mb_convert_encoding($newFormat, $encoding, 'UTF-8');
        return !empty($newArgv) ? vsprintf($newFormat, $newArgv) : $newFormat;
    }
}
