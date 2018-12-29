<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Backend\Controllers;

use Zemit\Mvc\View;

/**
 * @TODO security
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @package Zemit\Modules\Backend
 */
class PartialsController extends AbstractController
{
    public $notFound = [
        'controller' => 'errors',
        'action' => 'notFound',
    ];
    
    public $extensions = [
        '.phtml',
        '.html',
        '.php',
        '.volt',
    ];
    
    public $partialFolder = '/partials/';
    
    /**
     *
     */
    public function notFoundAction()
    {
        // Build the partial view path
        $path = $this->config->partials->folder ?? $this->partialFolder . implode('/', func_get_args());
        $pathinfo = pathinfo($path);
        $viewPath = $pathinfo['dirname'] . $pathinfo['filename'];
        
        if ($this->view->exists($viewPath)) {
            
            // Force the partial without layout
            $this->view->cleanTemplateAfter();
            $this->view->cleanTemplateBefore();
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
            $this->view->pick($viewPath);
        } else {
            
            // Can't find the partial, forward to not found
            $this->dispatcher->forward($this->config->router->notFound ?? $this->notFound);
        }
    }
    
}
