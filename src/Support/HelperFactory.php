<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

use Zemit\Support\Helper\Arr\FlattenKeys;
use Zemit\Support\Helper\Arr\RecursiveMap;
use Zemit\Support\Helper\Arr\RecursiveStrReplace;
use Zemit\Support\Helper\Str\NormalizeLineBreaks;
use Zemit\Support\Helper\Str\RemoveNonPrintable;
use Zemit\Support\Helper\Str\SanitizeUTF8;
use Zemit\Support\Helper\Str\Slugify;

/**
 * HelperFactory Class
 *
 * This class extends the Phalcon\Support\HelperFactory class and provides additional helper services.
 * @method string basename(string $uri, string $suffix = null)
 * @method array  blacklist(array $collection, array $blackList)
 * @method string camelize(string $text, string $delimiters = null, bool $lowerFirst = false)
 * @method array  chunk(array $collection, int $size, bool $preserveKeys = false)
 * @method string concat(string $delimiter, string $first, string $second, string ...$arguments)
 * @method int    countVowels(string $text)
 * @method string decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8')
 * @method string decode(string $data, bool $associative = false, int $depth = 512, int $options = 0)
 * @method string decrement(string $text, string $separator = '_')
 * @method string dirFromFile(string $file)
 * @method string dirSeparator(string $directory)
 * @method string encode($data, int $options = 0, int $depth = 512)
 * @method bool   endsWith(string $haystack, string $needle, bool $ignoreCase = true)
 * @method mixed  first(array $collection, callable $method = null)
 * @method string firstBetween(string $text, string $start, string $end)
 * @method mixed  firstKey(array $collection, callable $method = null)
 * @method string friendly(string $text, string $separator = '-', bool $lowercase = true, $replace = null)
 * @method array  flatten(array $collection, bool $deep = false)
 * @method mixed  get(array $collection, $index, $defaultValue = null, string $cast = null)
 * @method array  group(array $collection, $method)
 * @method bool   has(array $collection, $index)
 * @method string humanize(string $text)
 * @method bool   includes(string $haystack, string $needle)
 * @method string increment(string $text, string $separator = '_')
 * @method bool   isAnagram(string $first, string $second)
 * @method bool   isBetween(int $value, int $start, int $end)
 * @method bool   isLower(string $text, string $encoding = 'UTF-8')
 * @method bool   isPalindrome(string $text)
 * @method bool   isUnique(array $collection)
 * @method bool   isUpper(string $text, string $encoding = 'UTF-8')
 * @method string kebabCase(string $text, string $delimiters = null)
 * @method mixed  last(array $collection, callable $method = null)
 * @method mixed  lastKey(array $collection, callable $method = null)
 * @method int    len(string $text, string $encoding = 'UTF-8')
 * @method string lower(string $text, string $encoding = 'UTF-8')
 * @method array  order(array $collection, $attribute, string $order = 'asc')
 * @method string pascalCase(string $text, string $delimiters = null)
 * @method array  pluck(array $collection, string $element)
 * @method string prefix($text, string $prefix)
 * @method string random(int $type = 0, int $length = 8)
 * @method string reduceSlashes(string $text)
 * @method array  set(array $collection, $value, $index = null)
 * @method array  sliceLeft(array $collection, int $elements = 1)
 * @method array  sliceRight(array $collection, int $elements = 1)
 * @method string snakeCase(string $text, string $delimiters = null)
 * @method array  split(array $collection)
 * @method bool   startsWith(string $haystack, string $needle, bool $ignoreCase = true)
 * @method string suffix($text, string $suffix)
 * @method object toObject(array $collection)
 * @method bool   validateAll(array $collection, callable $method)
 * @method bool   validateAny(array $collection, callable $method)
 * @method string ucwords(string $text, string $encoding = 'UTF-8')
 * @method string uncamelize(string $text, string $delimiters = '_')
 * @method string underscore(string $text)
 * @method string upper(string $text, string $encoding = 'UTF-8')
 * @method array  whitelist(array $collection, array $whiteList)
 * 
 * # New methods
 * @method string recursiveMap(array $collection = [], callable $callback = null)
 * @method string flattenKeys(array $collection = [], string $delimiter = '.', bool $lowerKey = true)
 * @method string recursiveStrReplace(array $collection, array $replaces)
 * @method string slugify(string $string, array $replace = [], string $delimiter = '-')
 * @method string sanitizeUTF8(string $string)
 * @method string removeNonPrintable(string $string, string $nonPrintableRegex = '[[:cntrl:]' . PHP_EOL . ']', string $replacement = '')
 * @method string normalizeLineBreaks(string $string, string $nonPrintableRegex = "\r\n", string $replacement = "\r")
 */
class HelperFactory extends \Phalcon\Support\HelperFactory
{
    /**
     * Returns the available adapters
     *
     * @return string[]
     */
    protected function getServices(): array
    {
        return array_merge(parent::getServices(), [
            'recursiveMap' => RecursiveMap::class,
            'flattenKeys' => FlattenKeys::class,
            'recursiveStrReplace' => RecursiveStrReplace::class,
            'slugify' => Slugify::class,
            'sanitizeUTF8' => SanitizeUTF8::class,
            'removeNonPrintable' => RemoveNonPrintable::class,
            'normalizeLineBreaks' => NormalizeLineBreaks::class,
        ]);
    }
}
