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

use Phalcon\Support\Collection;
use Zemit\Modules\Api\Controller;

class UserController extends Controller
{
    public function initializeWith(): void
    {
        $this->setWith(new Collection([
            'RoleList',
        ]));
    }
    
    public function initializeSearchFields(): void
    {
        $this->setSearchFields(new Collection([
            'id',
            'email',
            'firstName',
            'lastName',
        ]));
    }
    
    public function initializeExposeFields(): void
    {
        $this->setExposeFields(new Collection([
            true,
            'password' => false,
        ]));
    }
}
