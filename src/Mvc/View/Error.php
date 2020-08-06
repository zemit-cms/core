<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\View;

use Zemit\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

/**
 * Class Error
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\View
 */
class Error extends Injectable
{
    /**
     * @param Event $event
     * @param ViewInterface $view
     * @param null $currentView
     */
    public function beforeRenderView(Event $event, ViewInterface $view, $currentView = null)
    {
    
    }
    
    /**
     * @param Event $event
     * @param ViewInterface $view
     * @param null $currentView
     */
    public function notFoundView(Event $event, ViewInterface $view, $currentView = null)
    {
    
    }
}
