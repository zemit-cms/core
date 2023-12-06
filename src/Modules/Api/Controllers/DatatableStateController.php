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

use App\Modules\Api\Controllers\AbstractController;

class DatatableStateController extends AbstractController
{
    public function getWhiteList()
    {
        return [
            'id',
            'index',
            'label',
            'userId',
            'label',
            'json',
            'deleted',
        ];
    }

    public function getFilterWhiteList()
    {
        return [
            'id',
            'index',
            'label',
            'userId',
            'label',
            'deleted',
        ];
    }

    public function getWith() {
        return [];
    }

    public function getListWith() {
        return [];
    }

    public function getExpose() {
        return [
            false,
            'id',
            'index',
            'userId',
            'label',
            'json',
            'deleted',
        ];
    }

    public function getPermissionCondition($type = null, $identity = null)
    {
        $permissionCondition[] = parent::getPermissionCondition();
        $permissionCondition[] = $this->getUserIdPermissionCondition('userId');

        return '(' . implode(') AND (', array_values(array_filter(array_unique($permissionCondition)))) . ')';
    }
}
