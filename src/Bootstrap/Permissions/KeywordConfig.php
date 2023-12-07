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
use Zemit\Modules\Api\Controllers\KeywordController;
use Zemit\Models\Keyword;

class KeywordConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewKeywordList' => [
                        'components' => [
                            KeywordController::class => ['get', 'get-all'],
                            Keyword::class => ['find'],
                        ],
                        'behaviors' => [
                            KeywordController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'manageKeywordList' => [
                        'components' => [
                            KeywordController::class => ['*'],
                            Keyword::class => ['*'],
                        ],
                        'behaviors' => [
                            KeywordController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],
                ],
                'roles' => [
                    'researcher' => [
                        'features' => [
                            'viewKeywordList',
                            'manageKeywordList',
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
