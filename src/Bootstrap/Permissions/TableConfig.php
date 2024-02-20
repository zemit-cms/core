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

use Phalcon\Config as PhalconConfig;
use Zemit\Config\Config as ZemitConfig;
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;
use Zemit\Modules\Api\Controllers\TableController;
use Zemit\Models\Table;

class TableConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
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
        ], $insensitive);

        if (!empty($data)) {
            $this->merge(new PhalconConfig($data, $insensitive));
        }
    }
}
