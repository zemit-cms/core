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
use Zemit\Modules\Api\Controllers\ColumnController;
use Zemit\Models\Column;

class ColumnConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageColumnList' => [
                        'components' => [
                            ColumnController::class => ['*'],
                            Column::class => ['*'],
                        ],
                        'behaviors' => [
                            ColumnController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewColumnList' => [
                        'components' => [
                            ColumnController::class => ['get', 'get-all'],
                            Column::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewColumnList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageColumnList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
