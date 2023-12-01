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

use Zemit\Modules\Frontend\Controller;
use Zemit\Tag;

abstract class AbstractController extends Controller
{
    public function initialize()
    {
        Tag::setAttr('html', ['lang' => $this->dispatcher->getParam('language', 'string', 'en')]);
        Tag::setTitle($this->config->path('core.name', 'Zemit Frontend'));
        
        $this->assets->collection('head')
            ->addCss('/head.css', true, true, [], true, true)
            ->addJs('/head.js', true, true, [], true, true);

        $this->assets->collection('footer')
            ->addJs('/footer.js', true, true, [], true, true);
    }
}
