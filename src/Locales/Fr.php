<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Locales;

use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;

/**
 * Class Fr
 * {@inheritDoc}
 *
 * @link https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Locale
 */
class Fr extends NativeArray
{
    public function __construct(InterpolatorFactory $interpolator, array $options)
    {
        $this->replacePlaceholders('zemit', [
            'zemit' => '<a href="https://www.zemit.com/">Zemit</a>'
        ]);
        
        parent::__construct($interpolator, array_merge_recursive([
            'locale' => 'fr_CA.UTF-8',
            'defaultDomain' => 'zemit',
            'category' => LC_MESSAGES,
            'content' => [
                'powered-by' => 'Propulsé par %zemit%.',
                'copyright' => '%zemit% &copy; 2017 Zemit.',
            ],
        ], $options));
    }
}
