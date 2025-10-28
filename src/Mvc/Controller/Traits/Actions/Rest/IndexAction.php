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

namespace Zemit\Mvc\Controller\Traits\Actions\Rest;

use Phalcon\Dispatcher\Exception;
use Phalcon\Filter\Filter;
use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;

trait IndexAction
{
    use AbstractInjectable;
    use AbstractParams;
    use AbstractRestResponse;
    
    /**
     * @throws Exception
     * @throws \Phalcon\Filter\Exception
     * @throws \Exception
     */
    public function indexAction(): ResponseInterface
    {
        $this->restForwarding();
        $ret = $this->dispatcher->getReturnedValue();
        return $ret instanceof ResponseInterface ? $ret : $this->setRestResponse($ret);
    }
    
    /**
     * @throws Exception
     * @throws \Phalcon\Filter\Exception
     */
    protected function restForwarding(): bool
    {
        $id = $this->getParam('id', [Filter::FILTER_INT]);
        if ($this->request->isPost() || $this->request->isPut() || $this->request->isPatch()) {
            $this->dispatcher->forward(['action' => 'save']);
            return true;
        }
        else if ($this->request->isDelete()) {
            $this->dispatcher->forward(['action' => 'delete']);
            return true;
        }
        else if ($this->request->isGet()) {
            $this->dispatcher->forward(['action' => is_null($id) ? 'find' : 'findFirst']);
            return true;
        }
        return false;
    }
}
