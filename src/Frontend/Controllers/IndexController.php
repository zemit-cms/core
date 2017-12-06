<?php

namespace Zemit\Core\Frontend\Controllers;

use Zemit\Core\Frontend\Controller;

use Zemit\Core\Tag;

class IndexController extends Controller
{
    public function indexAction() {
        Tag::setAttribute('body', ['class' => 'test1']);
        Tag::setAttribute('body', ['class' => 'test2']);
        Tag::setAttribute('html', ['class' => 'test3']);
        
        
        Tag::setAttribute('test', ['class' => 'test1']);
        Tag::setAttribute('test2', ['class' => ['test2', 'test3']]);

<div class="test1 test2 test3"></div>
        
//        var_dump(Tag::getAttribute(null, ['body', 'html']));
//        die();
        
//        $this->tag->setAttribute('html', ['ng-class' => "{strike: deleted, bold: important, 'has-error': error}"]);
//        $this->tag->addMeta('name', 'generator', 'Zemit CMS');
//        $this->tag->setMetaName('generator', 'Zemit CMS 1');
//        $this->tag->setMetaName('generator', 'Zemit CMS 2');
//        $this->tag->addMeta('charset', 'UTF-8');
//        $this->tag->setMetaCharset();
    }
}