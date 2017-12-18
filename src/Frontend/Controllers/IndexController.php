<?php

namespace Zemit\Core\Frontend\Controllers;

use Zemit\Core\Frontend\Controller;

use Zemit\Core\Tag;

class IndexController extends Controller
{
    public function indexAction() {
//        Tag::setAttr('body', ['class' => 'test1']);
//        Tag::setAttr('body', ['class' => 'test2']);
//        Tag::setAttr('html', ['class' => [['test']]]);
        
        Tag::setAttr('html', (object)array('test' => (object)array('test' => (object)array('test' => 'test'))));
        Tag::setAttr('html', (object)array('test' => (object)array('test2' => (object)array('test' => 'test3'))));
        
//        var_dump(Tag::getAttr('html'));
//        die();
        
    }
}