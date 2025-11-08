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

namespace PhalconKit\Bootstrap\Permissions;

use PhalconKit\Config\Config;
use PhalconKit\Mvc\Model\Dynamic;

class DynamicConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageDynamicList' => [
                        'components' => [
                            Dynamic::class => ['*'],
                        ],
                        'behaviors' => [
                        ],
                    ],
                    'viewDynamicList' => [
                        'components' => [
                            Dynamic::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewDynamicList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageDynamicList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
