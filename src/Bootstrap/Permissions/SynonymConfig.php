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
use Zemit\Modules\Api\Controllers\SynonymController;
use Zemit\Models\Synonym;

class SynonymConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewSynonymList' => [
                        'components' => [
                            SynonymController::class => ['get', 'get-all'],
                            Synonym::class => ['find'],
                        ],
                        'behaviors' => [
                            SynonymController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageSynonymList' => [
                        'components' => [
                            SynonymController::class => ['*'],
                            Synonym::class => ['*'],
                        ],
                        'behaviors' => [
                            SynonymController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                ],
                'roles' => [
                    'researcher' => [
                        'features' => [
                            'viewSynonymList',
                            'manageSynonymList',
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
