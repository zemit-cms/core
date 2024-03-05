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
use Zemit\Modules\Api\Controllers\WorkspaceController;
use Zemit\Models\Workspace;

class WorkspaceConfig extends ZemitConfig
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
