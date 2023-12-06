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
use Zemit\Modules\Api\Controllers\ArticleController;
use Zemit\Models\Article;
use Zemit\Models\File;

class ArticleConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewArticleList' => [
                        'components' => [
                            ArticleController::class => ['get', 'get-all'],
                            Article::class => ['find'],
                        ],
                        'behaviors' => [
                            ArticleController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'saveArticle' => [
                        'components' => [
                            ArticleController::class => ['save', 'delete'],
                            Article::class => ['find', 'create', 'update', 'delete'],
                        ],
                    ],
                    'parseArticleFile' => [
                        'components' => [
                            ArticleController::class => ['parse-file'],
                            Article::class => ['find'],
                            File::class => ['find'],
                        ],
                    ],
                ],
                'roles' => [
                    'researcher' => [
                        'features' => [
                            'viewArticleList',
                            'saveArticle',
                            'parseArticleFile',
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
