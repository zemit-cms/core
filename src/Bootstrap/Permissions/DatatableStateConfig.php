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
use Zemit\Modules\Api\Controllers\DatatableStateController;
use Zemit\Models\DatatableState;

class DatatableStateConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'manageDatatableStateList' => [
                        'components' => [
                            DatatableStateController::class => ['*'],
                            DatatableState::class => ['*'],
                        ],
                    ],
                ],
                'roles' => [
                    'user' => [
                        'features' => [
                            'manageDatatableStateList',
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
