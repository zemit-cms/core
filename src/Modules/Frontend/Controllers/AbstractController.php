<?php

namespace Zemit\Modules\Frontend\Controllers;

use Zemit\Modules\Frontend\Controller;
use Zemit\Tag;

abstract class AbstractController extends Controller
{
    public function initialize() {
        Tag::setAttr('html', ['lang' => $this->dispatcher->getParam('language', 'string', 'en')]);
    }
}