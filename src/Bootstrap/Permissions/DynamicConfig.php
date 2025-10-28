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

namespace Zemit\Bootstrap\Permissions;

use Zemit\Config\Config;
use Zemit\Mvc\Model\Dynamic;

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
