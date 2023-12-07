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

use Zemit\Models\Comment;
use Zemit\Models\ProjectStatusReason;
use Zemit\Models\Record;
use Zemit\Models\RecordUserStatus;
use Zemit\Modules\Api\Controllers\CommentController;
use Zemit\Modules\Api\Controllers\ProjectStatusReasonController;
use Zemit\Modules\Api\Controllers\RecordController;
use Zemit\Modules\Api\Controllers\RecordUserStatusController;
use Phalcon\Config as PhalconConfig;
use Zemit\Config\Config as ZemitConfig;
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;

class RecordConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewRecordList' => [
                        'components' => [
                            RecordController::class => ['get', 'get-all', 'get-metrics'],
                            Record::class => ['find'],
                        ],
                        'behaviors' => [
                            RecordController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageRecordList' => [
                        'components' => [
                            RecordController::class => ['*'],
                            Record::class => ['*'],
                            RecordUserStatus::class => ['*'],
                        ],
                        'behaviors' => [
                            RecordController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewRecordUserStatusList' => [
                        'components' => [
                            RecordUserStatusController::class => ['get', 'get-all'],
                            RecordUserStatus::class => ['find'],
                        ],
                        'behaviors' => [
                            RecordUserStatus::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'saveRecordUserStatus' => [
                        'controllers' => [
                            RecordController::class => ['save-user-status'],
                            ProjectStatusReasonController::class => ['get-all', 'save'],
                        ],
                        'models' => [
                            ProjectStatusReason::class => ['find', 'create'],
                            RecordUserStatus::class => ['find', 'create', 'update'],
                            Record::class => ['find', 'update'],
                        ],
                    ],
                ],
                'roles' => [
                    'researcher' => [
                        'features' => [
                            'viewRecordList',
                            'manageRecordList',
                            'viewRecordUserStatusList',
                            'saveRecordUserStatus',
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
