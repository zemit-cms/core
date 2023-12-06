<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Phalcon\Security\Exception;
use Zemit\Mvc\Controller\Identity;

class AuthController extends AbstractController
{
    use Identity {
        getAction as traitGetAction;
    }
    
    public function indexAction($id = null): bool
    {
        return $this->getAction();
    }
    
    /**
     * Create a refresh a session
     *
     * @param bool $refresh
     *
     * @return bool
     * @throws Exception
     */
    public function getAction($refresh = false): bool
    {
        $ret = $this->traitGetAction($refresh);
        
        $indexLabelExpose = [false, 'email', 'label'];
        $expose = [
            'User' => [false, 'id', 'email', 'firstName', 'lastName'],
            'Role' => $indexLabelExpose,
            'Group' => $indexLabelExpose,
            'Type' => $indexLabelExpose,
        ];
        
        // @todo review this
        $permissions = $this->config->path('permissions.roles', []);
        $view = ['permissionList' => ['everyone' => $permissions['everyone']['frontend'] ?? null]];
        foreach (['user', 'userAs', 'roleList', 'groupList', 'typeList'] as $var) {
            if (is_array($this->view->$var)) {
                foreach ($this->view->$var as $key => $role) {
                    if ($role) {
                        $view[$var][$key] = $role->expose($expose);
                        $view['permissionList'][$key] = $permissions[$key]['frontend'] ?? null;
                    }
                }
            }
            else if ($this->view->$var) {
                $view[$var] = $this->view->$var->expose($expose);
            }
        }
        $this->view->setVars($view);
        
        return $ret;
    }
}

