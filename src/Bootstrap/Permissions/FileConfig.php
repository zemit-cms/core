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
use Zemit\Modules\Api\Controllers\FileController as ApiFileController;
use Zemit\Modules\Frontend\Controllers\FileController as FrontendFileController;
use Zemit\Models\File;

class FileConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [
                    'showDownloadFile' => [
                        'components' => [
                            FrontendFileController::class => ['show', 'download'],
                            File::class => ['find'],
                        ],
                    ],
                    'uploadFile' => [
                        'components' => [
                            ApiFileController::class => ['upload'],
                            File::class => ['create'],
                        ],
                    ],
                ],
                'roles' => [
                    'tracker' => [
                        'features' => [
                            'showDownloadFile',
                        ],
                    ],
                    'researcher' => [
                        'features' => [
                            'uploadFile',
                            'showDownloadFile',
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
