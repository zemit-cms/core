<?php

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
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;
//use Zemit\Modules\Api\Controllers\DynamicController;
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
//                            DynamicController::class => ['*'],
                            Dynamic::class => ['*'],
                        ],
                        'behaviors' => [
//                            DynamicController::class => [
//                                SkipIdentityCondition::class,
//                                SkipSoftDeleteCondition::class,
//                            ],
                        ],
                    ],
                    'viewDynamicList' => [
                        'components' => [
//                            DynamicController::class => ['get', 'get-all'],
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
