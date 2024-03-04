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

use Zemit\Mvc\Controller\Rest;
use Zemit\Mvc\Controller\Traits\Actions\AuthActions;

class AuthController extends Rest
{
    use AuthActions {
        getAction as traitGetAction;
    }
    
    /**
     * Create a refresh a session
     *
     * @param bool $refresh
     */
    public function getAction(bool $refresh = false): bool
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
