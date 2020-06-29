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

/**
 * Trait Identity
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 * @property \Zemit\Identity $identity
 * @package Zemit\Mvc\Controller
 */
trait Identity
{
    /**
     * Create a refresh a session
     *
     * @param bool $refresh
     *
     * @return bool
     * @throws \Phalcon\Security\Exception
     */
    public function getAction($request)
    {
        $this->view->setVars($this->identity->getJwt($request === true));
        $this->view->setVars($this->identity->getIdentity());
        
        return $this->view->saved && $this->view->stored && $this->view->validated;
    }
    
    /**
     * Refresh or create a session
     *
     * @return bool
     * @throws \Phalcon\Security\Exception
     */
    public function refreshAction()
    {
        return $this->getAction(true);
    }
    
    /**
     * Login Action
     * - Require an active session to bind the logged in userId
     *
     * @return bool
     */
    public function loginAction()
    {
        $this->view->setVars($this->identity->login($this->getParams()));
        
        return $this->view->loggedIn;
    }
    
    /**
     * Login As Action
     * - Require an active session to bind the logged in userId
     *
     * @return bool
     */
    public function loginAsAction()
    {
        $this->view->setVars($this->identity->loginAs($this->getParams()));
        
        return $this->view->loggedInAs;
    }
    
    /**
     * Log the user out from the database session
     *
     * @return bool
     */
    public function logoutAction()
    {
        $this->view->setVars($this->identity->logout());
        
        return !$this->view->loggedIn;
    }
    
    /**
     * Login Action
     * - Require an active session to bind the logged in userId
     *
     * @return bool
     */
    public function logoutAsAction()
    {
        $this->view->setVars($this->identity->logoutAs());
        
        return $this->view->loggedInAs;
    }
}
