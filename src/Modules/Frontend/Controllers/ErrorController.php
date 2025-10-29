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

namespace Zemit\Modules\Frontend\Controllers;

use Zemit\Mvc\Controller\Traits\Actions\ErrorActions;
use Zemit\Mvc\Controller\Traits\StatusCode;
use Zemit\Tag;

class ErrorController extends AbstractController
{
    use StatusCode;
    use ErrorActions;
    
    /**
     * @return void
     */
    #[\Override]
    public function initialize(): void
    {
        $this->view->pick('error/index');
        parent::initialize();
    }
    
    public function afterExecuteRoute(): void
    {
        $title = $this->response->getReasonPhrase() ?: 'Error';
        Tag::appendTitle(' - ' . $title);
    }
}
