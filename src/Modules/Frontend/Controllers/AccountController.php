<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Frontend\Controllers;

class AccountController extends AbstractController
{
    public function indexAction() {
        $this->dispatcher->forward(['action' => 'login']);
    }
    
    public function loginAction() {
    
    }
    
    public function logoutAction() {
    
    }
    
    public function registerAction() {
    
    }
}
