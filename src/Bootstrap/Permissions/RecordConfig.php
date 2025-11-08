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
use PhalconKit\Modules\Api\Controllers\RecordController;
use PhalconKit\Models\Record;

class RecordConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageRecordList' => [
                        'components' => [
                            RecordController::class => ['*'],
                            Record::class => ['*'],
                        ],
                        'behaviors' => [
                            RecordController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewRecordList' => [
                        'components' => [
                            RecordController::class => ['get', 'get-all'],
                            Record::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewRecordList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageRecordList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
