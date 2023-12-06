<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */


namespace Zemit\Config\Permissions;

use Phalcon\Config as PhalconConfig;
use Zemit\Config\Config as ZemitConfig;
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;
use Zemit\Modules\Api\Controllers\TrackerFilterStateController;
use Zemit\Modules\Api\Controllers\TrackerController;
use Zemit\Models\TrackerFilterState;
use Zemit\Models\TrackerUser;
use Zemit\Models\Tracker;

class TrackerConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewTrackerList' => [
                        'components' => [
                            TrackerController::class => ['get', 'get-all'],
                            Tracker::class => ['find'],
                        ],
                        'behaviors' => [
                            TrackerController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageTrackerList' => [
                        'components' => [
                            TrackerController::class => ['*'],
                            TrackerUser::class => ['*'],
                            Tracker::class => ['*'],
                        ],
                        'behaviors' => [
                            TrackerController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'manageTrackerFilterStateList' => [
                        'components' => [
                            TrackerFilterStateController::class => ['*'],
                            TrackerFilterState::class => ['*'],
                        ],
                    ],
                ],
                'roles' => [
                    'tracker' => [
                        'features' => [
                            'viewTrackerList',
                            'manageTrackerList',
                            'manageTrackerFilterStateList',
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
