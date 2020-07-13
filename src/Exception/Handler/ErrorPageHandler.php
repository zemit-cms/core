<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Exception\Handler;

use Phalcon\Di;
use Whoops\Handler\Handler;

/**
 * Zemit\Exception\Handler\ErrorPageHandler
 *
 * @package Zemit\Exception\Handler
 */
class ErrorPageHandler extends Handler
{
    private $unHandleCodes = [
        E_WARNING => true,
        E_NOTICE => true,
        E_CORE_WARNING => true,
        E_COMPILE_WARNING => true,
        E_USER_WARNING => true,
        E_USER_NOTICE => true,
        E_STRICT => true,
        E_DEPRECATED => true,
        E_USER_DEPRECATED => true,
        E_ALL => true,
    ];
    
    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function handle()
    {
        $exception = $this->getException();
        
        if (!$exception instanceof \Exception && !$exception instanceof \Throwable) {
            return Handler::DONE;
        }
        
        if (!$this->isItPossibleToHandle()) {
            return Handler::DONE;
        }
        
        if ($this->shouldWeSkipCurrentCode($exception->getCode())) {
            return Handler::DONE;
        }
        
        $this->renderErrorPage();
        
        return Handler::QUIT;
    }
    
    private function shouldWeSkipCurrentCode($code): bool
    {
        return isset($this->unHandleCodes[$code]);
    }
    
    private function isItPossibleToHandle(): bool
    {
        return Di::getDefault()->has('viewSimple') &&
            Di::getDefault()->has('dispatcher') &&
            Di::getDefault()->has('response');
    }
    
    private function renderErrorPage()
    {
        $dispatcher = Di::getDefault()->get('dispatcher');
        $view = Di::getDefault()->get('viewSimple');
        $response = Di::getDefault()->get('response');
        $config = Di::getDefault()->get('config');
        
        $controller = $config('error.controller', 'error');
        $defaultAction = $config('error.action', 'show500');

        switch ($this->getException()->getCode()) {
            case 404:
                $action = 'show404';
                break;
            default:
                $action = $defaultAction;
        }
        
        /** @var \Phalcon\Mvc\Dispatcher $dispatcher */
        $dispatcher->setNamespaceName('Zemit\\Controllers');
        $dispatcher->setControllerName($controller);
        $dispatcher->setActionName($action);
        $dispatcher->dispatch();
        
        $content = $view->render("$controller/$action", $dispatcher->getParams());
        
        $response->setContent($content)->send();
    }
}
