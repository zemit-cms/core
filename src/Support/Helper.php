<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Support;

use Phalcon\Di\Di;

/**
 * Class Helper
 *
 * This class is responsible for providing helper methods and functions.
 *
 * Native methods
 * @method static string basename(string $uri, string $suffix = null)
 * @method static array  blacklist(array $collection, array $blackList)
 * @method static string camelize(string $text, string $delimiters = null, bool $lowerFirst = false)
 * @method static array  chunk(array $collection, int $size, bool $preserveKeys = false)
 * @method static string concat(string $delimiter, string $first, string $second, string ...$arguments)
 * @method static int    countVowels(string $text)
 * @method static string decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8')
 * @method static string decode(string $data, bool $associative = false, int $depth = 512, int $options = 0)
 * @method static string decrement(string $text, string $separator = '_')
 * @method static string dirFromFile(string $file)
 * @method static string dirSeparator(string $directory)
 * @method static string encode($data, int $options = 0, int $depth = 512)
 * @method static bool   endsWith(string $haystack, string $needle, bool $ignoreCase = true)
 * @method static mixed  first(array $collection, callable $method = null)
 * @method static string firstBetween(string $text, string $start, string $end)
 * @method static mixed  firstKey(array $collection, callable $method = null)
 * @method static string friendly(string $text, string $separator = '-', bool $lowercase = true, $replace = null)
 * @method static array  flatten(array $collection, bool $deep = false)
 * @method static mixed  get(array $collection, $index, $defaultValue = null, string $cast = null)
 * @method static array  group(array $collection, $method)
 * @method static bool   has(array $collection, $index)
 * @method static string humanize(string $text)
 * @method static bool   includes(string $haystack, string $needle)
 * @method static string increment(string $text, string $separator = '_')
 * @method static bool   isAnagram(string $first, string $second)
 * @method static bool   isBetween(int $value, int $start, int $end)
 * @method static bool   isLower(string $text, string $encoding = 'UTF-8')
 * @method static bool   isPalindrome(string $text)
 * @method static bool   isUnique(array $collection)
 * @method static bool   isUpper(string $text, string $encoding = 'UTF-8')
 * @method static string kebabCase(string $text, string $delimiters = null)
 * @method static mixed  last(array $collection, callable $method = null)
 * @method static mixed  lastKey(array $collection, callable $method = null)
 * @method static int    len(string $text, string $encoding = 'UTF-8')
 * @method static string lower(string $text, string $encoding = 'UTF-8')
 * @method static array  order(array $collection, $attribute, string $order = 'asc')
 * @method static string pascalCase(string $text, string $delimiters = null)
 * @method static array  pluck(array $collection, string $element)
 * @method static string prefix($text, string $prefix)
 * @method static string random(int $type = 0, int $length = 8)
 * @method static string reduceSlashes(string $text)
 * @method static array  set(array $collection, $value, $index = null)
 * @method static array  sliceLeft(array $collection, int $elements = 1)
 * @method static array  sliceRight(array $collection, int $elements = 1)
 * @method static string snakeCase(string $text, string $delimiters = null)
 * @method static array  split(array $collection)
 * @method static bool   startsWith(string $haystack, string $needle, bool $ignoreCase = true)
 * @method static string suffix($text, string $suffix)
 * @method static object toObject(array $collection)
 * @method static bool   validateAll(array $collection, callable $method)
 * @method static bool   validateAny(array $collection, callable $method)
 * @method static string ucwords(string $text, string $encoding = 'UTF-8')
 * @method static string uncamelize(string $text, string $delimiters = '_')
 * @method static string underscore(string $text)
 * @method static string upper(string $text, string $encoding = 'UTF-8')
 * @method static array  whitelist(array $collection, array $whiteList)
 * 
 * New methods
 * @method static string recursiveMap(array $collection = [], callable $callback = null)
 * @method static string flattenKeys(array $collection = [], string $delimiter = '.', bool $lowerKey = true)
 * @method static string recursiveStrReplace(array $collection, array $replaces)
 * @method static string slugify(string $string, array $replace = [], string $delimiter = '-')
 * @method static string sanitizeUTF8(string $string, string $invalidUtf8Regex)
 * @method static string removeNonPrintable(string $string, string $nonPrintableRegex = '[[:cntrl:]\r\n]', string $replacement = '')
 * @method static string normalizeLineBreaks(string $string, string $nonPrintableRegex = "\r\n", string $replacement = "\r")
 */
class Helper
{
    /**
     * @var ?HelperFactory
     */
    public static ?HelperFactory $helperFactory = null;
    
    /**
     * Returns the instance of the HelperFactory class.
     *
     * This method is responsible for providing the HelperFactory instance.
     * If the instance is already set, it returns the existing instance.
     * If the instance is not set, it tries to retrieve it from the dependency injection container.
     * If the instance is not found in the container, it creates a new instance of HelperFactory.
     *
     * @return HelperFactory The instance of the HelperFactory class.
     */
    public static function getHelperFactory(): HelperFactory
    {
        return self::$helperFactory ??= Di::getDefault()?->get('helper') ?? new HelperFactory();
    }
    
    /**
     * Magic method __callStatic
     *
     * This method is a magic method that allows calling static methods dynamically.
     *
     * @param string $name The name of the static method to call.
     * @param array $arguments Arguments to pass to the static method.
     * 
     * @return mixed The result of the static method call.
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return self::getHelperFactory()->$name(...$arguments);
    }
}
