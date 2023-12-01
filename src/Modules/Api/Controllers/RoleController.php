<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Zemit\Modules\Api\Controller;

class RoleController extends Controller
{
    public function getWith(): ?array
    {
        return [
            'UserList',
        ];
    }
    
    public function getSearchWhiteList(): ?array
    {
        return [
            'index',
            'labelFr',
            'labelEn',
        ];
    }
    
    public function getExpose(): ?array
    {
        return [
            'Role' => true,
        ];
    }
}
