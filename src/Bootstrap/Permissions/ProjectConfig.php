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
use Zemit\Modules\Api\Controllers\ProjectFilterStateController;
use Zemit\Modules\Api\Controllers\ProjectController;
use Zemit\Models\ProjectFilterState;
use Zemit\Models\ProjectUser;
use Zemit\Models\Project;

class ProjectConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewProjectList' => [
                        'components' => [
                            ProjectController::class => ['get', 'get-all'],
                            Project::class => ['find'],
                        ],
                        'behaviors' => [
                            ProjectController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageProjectList' => [
                        'components' => [
                            ProjectController::class => ['*'],
                            Project::class => ['*'],
                            ProjectUser::class => ['*'],
                        ],
                        'behaviors' => [
                            ProjectController::class => [
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'manageProjectFilterStateList' => [
                        'components' => [
                            ProjectFilterStateController::class => ['*'],
                            ProjectFilterState::class => ['*'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewProjectList',
                            'manageProjectFilterStateList',
                        ],
                    ],
                    'arbitrator' => [
                        'features' => [
                            'manageProjectList'
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
