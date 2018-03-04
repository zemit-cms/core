<?php

namespace Zemit\Core\Frontend\Controllers;

class IndexController extends AbstractController
{
    public function indexAction() {
        var_dump($this->locale->getLocale());
        die();
//        dd($this->locale->getLocale());
//        dd($this->dispatcher->getParam('locale'));
    }
}