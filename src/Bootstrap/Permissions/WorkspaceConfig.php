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
use PhalconKit\Modules\Api\Controllers\WorkspaceController;
use PhalconKit\Models\Workspace;

class WorkspaceConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageWorkspaceList' => [
                        'components' => [
                            WorkspaceController::class => ['*'],
                            Workspace::class => ['*'],
                        ],
                        'behaviors' => [
                            WorkspaceController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewWorkspaceList' => [
                        'components' => [
                            WorkspaceController::class => ['get', 'get-all'],
                            Workspace::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewWorkspaceList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageWorkspaceList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
