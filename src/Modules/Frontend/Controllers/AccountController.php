<?php

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