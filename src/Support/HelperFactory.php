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
use Zemit\Support\Helper\Str\NormalizeLineBreaks;
use Zemit\Support\Helper\Str\RemoveNonPrintable;
use Zemit\Support\Helper\Str\SanitizeUTF8;
use Zemit\Support\Helper\Str\Slugify;

/**
 * HelperFactory Class
 *
 * This class extends the Phalcon\Support\HelperFactory class and provides additional helper services.
 * {@inheritdoc}
 * 
 * # New methods
 * @method string flattenKeys(array $collection = [], string $delimiter = '.', bool $lowerKey = true)
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
            'flattenKeys' => FlattenKeys::class,
            'slugify' => Slugify::class,
            'sanitizeUTF8' => SanitizeUTF8::class,
            'removeNonPrintable' => RemoveNonPrintable::class,
            'normalizeLineBreaks' => NormalizeLineBreaks::class,
        ]);
    }
}
