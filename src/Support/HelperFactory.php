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
use Zemit\Support\Helper\Str\Slugify;

/**
 * HelperFactory Class
 *
 * This class extends the Phalcon\Support\HelperFactory class and provides additional helper services.
 * {@inheritdoc}
 * 
 * @method string flattenKeys(array $collection = [], string $delimiter = '.', bool $lowerKey = true)
 * @method string slugify(string $string, array $replace = [], string $delimiter = '-')
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
        ]);
    }
}
