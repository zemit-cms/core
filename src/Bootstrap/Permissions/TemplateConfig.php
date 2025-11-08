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
use PhalconKit\Modules\Api\Controllers\TemplateController;
use PhalconKit\Models\Template;

class TemplateConfig extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            'permissions' => [
                'features' => [
                    'manageTemplateList' => [
                        'components' => [
                            TemplateController::class => ['*'],
                            Template::class => ['*'],
                        ],
                        'behaviors' => [
                            TemplateController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                    'viewTemplateList' => [
                        'components' => [
                            TemplateController::class => ['get', 'get-all'],
                            Template::class => ['find', 'findFirst'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewTemplateList',
                        ],
                    ],
                    'admin' => [
                        'features' => [
                            'manageTemplateList',
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
