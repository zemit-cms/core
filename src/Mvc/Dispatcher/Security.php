<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Acl\Resource;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Zemit\Di\Injectable;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Security extends Injectable
{
    
    
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher)
    {
        // get controller and action
        $module = $dispatcher->getModuleName();
        $namespace = $dispatcher->getNamespaceName();
        $controller = $dispatcher->getControllerName();
        $controllerClass = $dispatcher->getControllerClass();
        $action = $dispatcher->getActionName();
        
        $acl = $this->security->getAcl('controllers');
        
        // Security not found
        if (!$acl->isComponent($controllerClass)) {
            $dispatcher->forward($this->config->router->notFound->toArray());
            return false;
        }
        
        $allowed = false;
        
        $roles = $this->identity->getAclRoles();
        foreach ($roles as $role) {
            $allowed = $acl->isAllowed($role, $controllerClass, $action);
            if ($allowed) {
                break;
            }
        }
        
        $permissions = $this->config->permissions->toArray() ?? [];
        if (empty($permissions)) {
            $allowed = true;
        }
        
        if (!$allowed) {
            if (count($roles) > 1) {
                if (
                    $this->config->router->unauthorized->namespace === $namespace &&
                    $this->config->router->unauthorized->module === $module &&
                    $this->config->router->unauthorized->controller === $controller &&
                    $this->config->router->unauthorized->action === $action
                ) {
                    return true;
                }
                $dispatcher->forward($this->config->router->unauthorized->toArray());
            }
            else {
                if (
                    $this->config->router->forbidden->namespace === $namespace &&
                    $this->config->router->forbidden->module === $module &&
                    $this->config->router->forbidden->controller === $controller &&
                    $this->config->router->forbidden->action === $action) {
                    return true;
                }
                $dispatcher->forward($this->config->router->forbidden->toArray());
            }
            return false;
        }
    }
}
