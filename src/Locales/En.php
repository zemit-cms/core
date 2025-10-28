<?php

declare(strict_types=1);

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

class En extends NativeArray
{
    public function __construct(InterpolatorFactory $interpolator, array $options = [])
    {
        $config = [
            'locale' => 'en_CA.UTF-8',
            'defaultDomain' => 'zemit',
            'content' => [
                'powered-by' => 'Powered by %zemit%.',
                'copyright' => '%zemit% &copy; 2017 Zemit.',
            ],
        ];
        
        // Only set category if LC_MESSAGES is actually defined (Unix/Linux systems with gettext)
        if (defined('LC_MESSAGES')) {
            $config['category'] = LC_MESSAGES;
        }
        
        parent::__construct($interpolator, array_merge_recursive($config, $options));
    }
}
