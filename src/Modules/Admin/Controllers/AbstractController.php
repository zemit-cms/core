<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Admin\Controllers;

use Zemit\Modules\Admin\Controller;
use Zemit\Tag;

abstract class AbstractController extends Controller
{
    public function initialize(): void
    {
        Tag::setAttr('html', ['lang' => $this->dispatcher->getParam('language', 'string', 'en')]);
        Tag::setTitle($this->config->path('core.name') ?: 'Zemit Admin');
        $this->assets->collection('head')->addCss('/style.css', true, true, [], null, true);
    }
}
