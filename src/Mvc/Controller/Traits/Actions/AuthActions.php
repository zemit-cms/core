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

namespace Zemit\Mvc\Controller\Traits\Actions;

use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\StatusCode;

trait AuthActions
{
    use AbstractInjectable;
    use AbstractParams;
    use StatusCode;
    
    public array $userExpose = [
        true,
        'password' => false,
        'passwordConfirm' => false,
        'token' => false,
        'tokenHash' => false,
        'roleList' => false,
    ];
    
    /**
     * Retrieve the current identity information
     */
    public function getIdentityAction(): bool
    {
        $this->view->setVars($this->identity->getIdentity($this->userExpose));
        return $this->view->getVar('loggedIn') ?? false;
    }
    
    /**
     * Create or refresh a JWT
     */
    public function getJwtAction(bool $refresh = false): bool
    {
        $this->view->setVars($this->identity->getJwt($refresh));
        return (bool)$this->view->getVar('jwt');
    }
    
    /**
     * Refresh an existing JWT
     */
    public function refreshAction(): bool
    {
        return $this->getJwtAction(true);
    }

    /**
     * Login
     */
    public function loginAction(): bool
    {
        $this->view->setVars($this->identity->getJwt());
        $this->view->setVars($this->identity->login($this->getParams()));
        $this->view->setVars($this->identity->getIdentity($this->userExpose));
        $loggedIn = $this->view->getVar('loggedIn') ?? false;
        
        if (!$loggedIn) {
            $this->setStatusCode(401);
        }
        
        return $loggedIn;
    }

    /**
     * Login As (impersonation)
     */
    public function loginAsAction(): bool
    {
        $this->view->setVars($this->identity->getJwt());
        $this->view->setVars($this->identity->loginAs($this->getParams()));
        $this->view->setVars($this->identity->getIdentity($this->userExpose));
        return $this->view->getVar('loggedInAs') ?? false;
    }

    /**
     * Logout from current session
     */
    public function logoutAction(): bool
    {
        $this->view->setVars($this->identity->logout());
        return !$this->view->getVar('loggedIn');
    }

    /**
     * Logout from impersonation
     */
    public function logoutAsAction(): bool
    {
        $this->view->setVars($this->identity->logoutAs());
        $this->view->setVars($this->identity->getIdentity($this->userExpose));
        return !($this->view->getVar('loggedInAs') ?? false);
    }

    /**
     * Reset Password Action
     */
    public function resetPasswordAction(): bool
    {
        $this->view->setVars($this->identity->reset($this->getParams()));
        return $this->view->getVar('reset') ?? false;
    }
}
