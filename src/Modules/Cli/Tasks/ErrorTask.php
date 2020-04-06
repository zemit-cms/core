<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Zemit\Modules\Cli\Task;

/**
 * Class ErrorsTask
 * @package Zemit\Modules\Cli\Tasks
 */
class ErrorTask extends Task
{
    /**
     * Par défaut, on forward vers ErrorsController::fatalAction()
     * Page d'erreur fatale - 500 Internal Server Error
     * @see ErrorController::fatalAction();
     */
    public function indexAction()
    {
        $this->dispatcher->forward(array(
            'action' => 'notFound'
        ));
    }
    
    /**
     * Page d'erreur fatale - 500 Internal Server Error
     */
    public function fatalAction()
    {
        $this->codeAction([500, 'Internal Server Error']);
    }
    
    /**
     * Page introuvable - 404 Not Found
     */
    public function notFoundAction()
    {
        $this->codeAction([404, 'Not Found']);
    }
    
    /**
     * Page inaccessible - 403 Forbidden
     */
    public function forbiddenAction()
    {
        $this->codeAction([403, 'Forbidden']);
    }
    
    /**
     * Accès non autorisé - 401 Unauthorized
     */
    public function unauthorizedAction()
    {
        $this->codeAction([401, 'Unauthorized']);
    }
    
    /**
     * Mauvaise requête - 400 Bad Request
     */
    public function badRequestAction()
    {
        $this->codeAction([400, 'Bad Request']);
    }
    
    /**
     * Service indisponible ou maintnance en cours - 503 Service Unavailable
     */
    public function maintenanceAction()
    {
        $this->codeAction([503, 'Service Unavailable']);
    }
    
    public function codeAction($params = []) {
        $ret = [];
        foreach ($params as $key => $param) {
            if (is_numeric($key)) {
                $ret []= $param;
            }
        }
        echo implode(' - ', $ret);
    }
}
