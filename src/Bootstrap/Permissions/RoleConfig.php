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
use Zemit\Modules\Api\Controllers\RoleController;
use Zemit\Models\Role;

class RoleConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewRoleList' => [
                        'components' => [
                            RoleController::class => ['get', 'get-all'],
                            Role::class => ['find'],
                        ],
                        'behaviors' => [
                            RoleController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageRoleList' => [
                        'components' => [
                            RoleController::class => ['*'],
                            Role::class => ['*'],
                        ],
                        'behaviors' => [
                            RoleController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                ],
                'roles' => [
                    'dev' => [
                        'features' => [
                            'manageRoleList',
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
