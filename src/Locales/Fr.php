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

namespace PhalconKit\Locales;

use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;

class Fr extends NativeArray
{
    public function __construct(InterpolatorFactory $interpolator, array $options = [])
    {
        $config = [
            'locale' => 'fr_CA.UTF-8',
            'defaultDomain' => 'phalcon-kit',
            'content' => [
                'powered-by' => 'Propulsé par %phalcon-kit%.',
                'copyright' => '%phalcon-kit% &copy; 2017 Phalcon Kit.',
            ],
        ];
        
        // Only set category if LC_MESSAGES is actually defined (Unix/Linux systems with gettext)
        if (defined('LC_MESSAGES')) {
            $config['category'] = LC_MESSAGES;
        }
        
        parent::__construct($interpolator, array_merge_recursive($config, $options));
    }
}
