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
use Zemit\Modules\Api\Controllers\CommentController;
use Zemit\Models\Comment;

class CommentConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'viewCommentList' => [
                        'components' => [
                            CommentController::class => ['get', 'get-all'],
                            Comment::class => ['find'],
                        ],
                        'behaviors' => [
                            CommentController::class => [
                                SkipIdentityCondition::class,
                            ],
                        ],
                    ],
                    'saveComment' => [
                        'components' => [
                            CommentController::class => ['save'],
                            Comment::class => ['find', 'create', 'update'],
                        ],
                    ],
                    'deleteComment' => [
                        'components' => [
                            CommentController::class => ['delete'],
                            Comment::class => ['find', 'delete'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'viewCommentList',
                            'saveComment',
                            'deleteComment',
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
