<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Actions;

use Xenolope\Quahog\Client;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\View;

/**
 * @property View $view
 * @property Client $clamav
 */
trait ClamavActions
{
    use AbstractInjectable;
    
    public function indexAction(): void
    {
        $this->clamav->startSession();
        $this->pingAction();
        $this->versionAction();
        $this->statsAction();
        $this->clamav->endSession();
    }
    
    public function scanAction(?string $filePath = null): bool
    {
        $this->clamav->startSession();
        $result = $this->clamav->scanFile($filePath ?? '');
        $this->clamav->endSession();
        
        $ret = [];
        $ret['ok'] = $result->isOk();
        $ret['error'] = $result->isError();
        $ret['found'] = $result->isFound();
        $ret['reason'] = $result->getReason();
        $ret['id'] = $result->getId();
        $ret['filename'] = $result->getFilename();
        
        $this->view->setVars($ret);
        
        return $ret['ok'];
    }
    
    public function pingAction(): bool
    {
        $ret = $this->clamav->ping();
        $this->view->setVar('ping', $ret);
        return $ret;
    }
    
    public function versionAction(): bool
    {
        $ret = $this->clamav->version();
        $this->view->setVar('version', $ret);
        return !empty($ret);
    }
    
    public function statsAction(): bool
    {
        $ret = $this->clamav->stats();
        $this->view->setVar('stats', $ret);
        return !empty($ret);
    }
    
    public function reloadAction(): bool
    {
        $ret = $this->clamav->reload();
        $this->view->setVar('reload', $ret);
        return $ret === 'RELOADING';
    }
}
