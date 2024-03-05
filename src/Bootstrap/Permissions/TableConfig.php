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
use Zemit\Modules\Api\Controllers\TableController;
use Zemit\Models\Table;

class TableConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageTableList' => [
                        'components' => [
                            TableController::class => ['*'],
                            Table::class => ['*'],
                        ],
                        'behaviors' => [
                            TableController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewTableList' => [
                        'components' => [
                            TableController::class => ['get', 'get-all'],
                            Table::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewTableList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageTableList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
