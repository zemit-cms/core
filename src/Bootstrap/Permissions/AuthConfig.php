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
use Zemit\Modules\Api\Controllers\AuthController;
use Zemit\Models\User;

class AuthConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'login' => [
                        'components' => [
                            AuthController::class => ['login'],
                            User::class => ['find'],
                        ],
                    ],
                    'refresh' => [
                        'components' => [
                            AuthController::class => ['get', 'refresh'],
                            User::class => ['find'],
                        ],
                    ],
                    'logout' => [
                        'components' => [
                            AuthController::class => ['logout'],
                            User::class => ['find'],
                        ],
                    ],
                ],
                'roles' => [
                    'everyone' => [
                        'features' => [
                            'refresh',
                            'logout',
                        ],
                    ],
                    'guest' => [
                        'features' => [
                            'login',
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
