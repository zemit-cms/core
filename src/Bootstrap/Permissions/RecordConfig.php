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
use Zemit\Modules\Api\Controllers\RecordController;
use Zemit\Models\Record;

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
