<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Xenolope\Quahog\Client;

/**
 * Trait Clamav
 * @property Client $clamav
 * @package Zemit\Mvc\Controller
 */
trait Clamav
{
    public function getAction($id = null)
    {
        $this->clamav->startSession();
        $this->view->ping = $this->clamav->ping();
        $this->view->version = $this->clamav->version();
        $this->view->stats = explode(PHP_EOL, $this->clamav->stats());
        $this->clamav->endSession();
    }
    
    public function reloadAction()
    {
        $this->view->reload = $this->clamav->reload();
    }
    
    public function shutdownAction()
    {
        $this->getAction();
        $this->view->shutdown = $this->clamav->shutdown();
    }
}
