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

use Zemit\Mvc\Controller\StatusCode;
use Zemit\Mvc\Controller\Errors;

class ErrorController extends AbstractController
{
    use StatusCode;
    use Errors;

    public function initialize()
    {
        $this->view->pick('error/index');
        parent::initialize();
    }
}
