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
use PhalconKit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use PhalconKit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;
use PhalconKit\Modules\Api\Controllers\TableController;
use PhalconKit\Models\Table;

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
