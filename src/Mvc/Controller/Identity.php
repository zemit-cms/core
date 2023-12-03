<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Phalcon\Encryption\Security\Exception;

/**
 * @property \Zemit\Identity $identity
 */
trait Identity
{
    /**
     * Create a refresh a session
     */
    public function getAction(bool $refresh = false): bool
    {
        $this->view->setVars($this->identity->getJwt($refresh === true));
        $this->view->setVars($this->identity->getIdentity());
        return $this->view->getVar('validated') ?? false;
    }
    
    /**
     * Refresh or create a session
     * @throws Exception
     */
    public function refreshAction(): bool
    {
        return $this->getAction(true);
    }

    /**
     * Login Action
     * - Require an active session to bind the logged in userId
     */
    public function loginAction(): bool
    {
        $this->view->setVars($this->identity->getJwt());
        $this->view->setVars($this->identity->login($this->getParams()));
        $this->view->setVars($this->identity->getIdentity());
        return $this->view->getVar('loggedIn') ?? false;
    }

    /**
     * Login As Action
     * - Requires an active session to bind the logged in userId
     */
    public function loginAsAction(): bool
    {
        $this->view->setVars($this->identity->loginAs($this->getParams()));
        return $this->view->getVar('loggedInAs') ?? false;
    }

    /**
     * Log the user out from the database session
     */
    public function logoutAction(): bool
    {
        $this->view->setVars($this->identity->logout());
        return !$this->view->getVar('loggedIn') ?? false;
    }

    /**
     * Login Action
     * - Requires an active session to bind the logged in userId
     */
    public function logoutAsAction(): bool
    {
        $this->view->setVars($this->identity->logoutAs());
        return $this->view->getVar('loggedInAs') ?? false;
    }

    /**
     * Reset Action
     * - Requires an active session to bind the logged in userId
     */
    public function resetAction(): bool
    {
        $this->view->setVars($this->identity->reset($this->getParams()));
        return $this->view->getVar('reset') ?? false;
    }
}
