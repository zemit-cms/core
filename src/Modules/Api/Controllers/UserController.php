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

/**
 * Class IndexController
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Api\Controllers
 */
class UserController extends Controller
{

    public function getWith() {
        return [
            'RoleList'
        ];
    }
    
    public function getSearchWhiteList()
    {
        return [
            'id',
            'email',
            'firstName',
            'lastName'
        ];
    }
    
    public function getExpose() {
        return [
            'User' => [
                true,
            ],
        ];
    }
    
}
