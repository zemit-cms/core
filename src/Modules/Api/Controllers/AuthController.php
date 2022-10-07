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

use Zemit\Modules\Api\Controller;
use Zemit\Mvc\Controller\Identity;

/**
 * Class AuthController
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Api\Controllers
 */
class AuthController extends Controller
{
    use Identity;

    public function indexAction($id = null)
    {
        return $this->getAction();
    }

    /**
     *
     */
    public function destroyAction() {
        return $this->session->destroy();
    }

    /**
     * Create a refresh a session
     *
     * @param bool $refresh
     *
     * @return bool
     * @throws \Phalcon\Encryption\Security\Exception
     */
    public function getAction($request = null)
    {
        $this->view->setVars($this->identity->getJwt($request === true));
        $this->view->setVars($this->identity->getIdentity());

        $indexLabelExpose = [false, 'email', 'label', 'labelFr', 'labelEn', 'addressId'];
        $expose = [
            'User' => [false, 'email', 'firstName', 'lastName', 'category', 'addressId', 'id', 'companyId'],
            'Role' => $indexLabelExpose,
            'Group' => $indexLabelExpose,
            'Type' => $indexLabelExpose,
        ];

        $permissions = $this->config->permissions->roles->toArray() ?? [];
        $permissionList = ['everyone' => $permissions['everyone']['frontend'] ?? null];
        $vars = [];
        foreach (['user', 'userAs', 'roleList', 'groupList', 'typeList'] as $var) {
            if (is_array($this->view->$var)) {
                foreach ($this->view->$var as $key => $role) {
                    if ($role) {
                        $vars[$var][$key] = $role->expose($expose);
                        $permissionList[$key] = $permissions[$key]['frontend'] ?? null;
                    }
                }
            } else if ($this->view->$var) {
                $vars[$var] = $this->view->$var->expose($expose);
            }
        }
        $this->view->setVars($vars);

        $this->view->permissionList = $permissionList;

        return $this->view->saved && $this->view->stored && $this->view->validated;
    }
}
