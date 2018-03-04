<?php

namespace Zemit\Core\Frontend\Controllers;

use Zemit\Core\Frontend\Controller;
use Zemit\Core\Tag;

abstract class AbstractController extends Controller
{
    public function initialize() {
        Tag::setAttr('html', ['lang' => $this->dispatcher->getParam('language', 'string', 'en')]);
    }
}