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
use Zemit\Modules\Api\Controllers\NotificationController;
use Zemit\Models\NotificationUserAck;
use Zemit\Models\NotificationUser;
use Zemit\Models\Notification;

class NotificationConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewNotificationList' => [
                        'components' => [
                            NotificationController::class => ['get', 'get-all', 'get-list', 'ack'],
                            Notification::class => ['find'],
                            NotificationUser::class => ['find'],
                            NotificationUserAck::class => ['find', 'create', 'save', 'update'],
                        ],
                        'behaviors' => [
                            NotificationController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'acknowledgeNotification' => [
                        'components' => [
                            NotificationController::class => ['get', 'get-all', 'get-list', 'ack'],
                        ],
                        'behaviors' => [
                            NotificationController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'manageNotificationList' => [
                        'components' => [
                            NotificationController::class => ['*'],
                            Notification::class => ['*'],
                            NotificationUser::class => ['*'],
                            NotificationUserAck::class => ['*'],
                        ],
                        'behaviors' => [
                            NotificationController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewNotificationList',
                            'acknowledgeNotification',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageNotificationList',
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
