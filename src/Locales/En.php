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
 * Class En
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
class En extends NativeArray
{
    /**
     * En constructor.
     * {@inheritDoc}
     *
     * @param InterpolatorFactory $interpolator
     * @param array $options
     */
    public function __construct(InterpolatorFactory $interpolator, array $options)
    {
        $this->replacePlaceholders('zemit', [
            'zemit' => '<a href="https://www.zemit.com/">Zemit</a>'
        ]);
        
        parent::__construct($interpolator, array_merge_recursive([
            'locale' => 'en_US.UTF-8',
            'defaultDomain' => 'zemit',
            'category' => LC_MESSAGES,
            'content' => [
                'powered-by' => 'Powered by %zemit%.',
                'copyright' => '%zemit% &copy; 2017 Zemit.',
            ],
        ], $options));
    }
}
