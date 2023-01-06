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
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
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
    public function getAction($refresh = false)
    {
        $this->view->setVars($this->identity->getJwt($refresh === true));
        $this->view->setVars($this->identity->getIdentity());
        
        return $this->view->validated;
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
        $this->view->setVars($this->identity->getJwt());
        $this->view->setVars($this->identity->login($this->getParams()));
        $this->view->setVars($this->identity->getIdentity());
        
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
    
    /**
     * Reset Action
     * - Require an active session to bind the logged in userId
     *
     * @return bool
     */
    public function resetAction()
    {
        $this->view->setVars($this->identity->reset($this->getParams()));
        
        return $this->view->reset;
    }
}
