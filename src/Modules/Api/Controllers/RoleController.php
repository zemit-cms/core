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

class RoleController extends Controller
{
    public function initializeWith(): void
    {
        $this->setWith(new Collection([
            'UserList',
        ]));
    }
    
    public function initializeSaveFields(): void
    {
        $this->setSaveFields(new Collection([
            'key',
            'labelFr',
            'labelEn'
        ]));
    }
    
    public function initializeExposeFields() : void
    {
        $this->setExposeFields(new Collection([
            true,
            'User' => [
                'password' => false,
            ],
        ]));
    }
}
