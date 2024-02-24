<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest\Actions;

use Phalcon\Dispatcher\Exception;
use Phalcon\Filter\Filter;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;

trait IndexAction
{
    use AbstractInjectable;
    
    /**
     * @throws Exception
     */
    public function indexAction(): ResponseInterface
    {
        $this->restForwarding();
        $ret = $this->dispatcher->getReturnedValue();
        return $ret instanceof ResponseInterface ? $ret : $this->setRestResponse($ret);
    }
    
    /**
     * @throws Exception
     */
    protected function restForwarding(): bool
    {
        $id = $this->getParam('id', [Filter::FILTER_ALNUM]);
        if ($this->request->isPost() || $this->request->isPut() || $this->request->isPatch()) {
            $this->dispatcher->forward(['action' => 'save']);
            return true;
        }
        else if ($this->request->isDelete()) {
            $this->dispatcher->forward(['action' => 'delete']);
            return true;
        }
        else if ($this->request->isGet()) {
            if (is_null($id)) {
                $this->dispatcher->forward(['action' => 'getList']);
                return true;
            }
            else {
                $this->dispatcher->forward(['action' => 'get']);
                return true;
            }
        }
        return false;
    }
}
