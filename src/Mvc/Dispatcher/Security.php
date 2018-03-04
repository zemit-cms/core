<?php

namespace Zemit\Core\Mvc\Dispatcher;

use Phalcon\Acl as PhalconAcl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Text;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Security extends Plugin
{
    // Everyone
    public $publicResources = array(
        'index' => array('index'),
        'errors' => array('*'),
        'login' => array('*'),
        'google' => array('auth'),
    );
    
    // User desjardins
    public $userResources = array(
        'index' => array('index'),
        'user' => array('*'),
        'logout' => array('*'),
        'dashboard' => array('*'),
        'contact' => array('*'),
        'group' => array('*'),
        'sector' => array('*'),
        'business' => array('*'),
        'incident' => array('*'),
        'google' => array('*'),
        'device' => array('*'),
        'data' => array('index', 'get', 'get-all'),
        'import' => array('index', 'get', 'get-all'),
        'jwt' => array('*'),
    );
    
    // Admin desjardins
    public $adminResources = array(
        'data' => array('*'),
        'import' => array('*'),
        'file' => array('*'),
        'log' => array('index', 'get', 'get-all'),
    );
    
    // Dev & penega
    public $devResources = array(
        'role' => array('*'),
        'file' => array('*'),
        'log' => array('*'),
        'backup' => array('*'),
        'email' => array('*'),
        'stats' => array('*'),
        'template' => array('*'),
        'cache' => array('*'),
    );
    
    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl()
    {
        $resources = array(
            'public' => $this->publicResources,
            'user' => $this->userResources,
            'admin' => array_merge_recursive($this->userResources, $this->adminResources),
            'dev' => array_merge_recursive($this->userResources, $this->adminResources, $this->devResources),
        );
        
        if (!isset($this->persistent->acl) || $this->config->debug) {
            $acl = new AclList();
            $acl->setDefaultAction(PhalconAcl::DENY);
            $acl->addRole(new Role('public', 'Public'));
            
            // Get db roles
            $roles = \Zemit\Core\Api\Models\Role::findByDeleted(0);
    
            // Register roles
            foreach ($roles as $role) {
                $acl->addRole(new Role($role->slug, $role->name));
            }
            
            //Public area resources
            $this->_fixCamelcaseHyphenResources($this->publicResources);
            foreach ($this->publicResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
                foreach ($actions as $action) {
                    $acl->allow('public', $resource, $action);
                }
            }
            
            // For each role, setup the Resources
            foreach ($roles as $role) {
    
                //Public area resources
                foreach ($this->publicResources as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($role->slug, $resource, $action);
                    }
                }
                
                // Setup the Resources
                if (isset($resources[$role->slug])) {
                    
                    $this->_fixCamelcaseHyphenResources($resources[$role->slug]);
                    foreach ($resources[$role->slug] as $resource => $actions) {
                        $acl->addResource(new Resource($resource), $actions);
                        foreach ($actions as $action) {
                            $acl->allow($role->slug, $resource, $action);
                        }
                    }
                }
            }
    
            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }
        
        return $this->persistent->acl;
    }
    
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $user = $this->zemit->getUser();
        if ($user) {
            $roles = $user->getRoles();
        }
        if (empty($roles)) {
            $roles = array(new \Zemit\Core\Api\Models\Role(array('name' => 'Public', 'slug' => 'public')));
        }
        
        // get controller and action
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        
        $acl = $this->getAcl();
        if (!$acl->isResource($controller)) {
            $dispatcher->forward([
                'controller' => 'errors',
                'action' => 'notFound'
            ]);
            return false;
        }
    
        $allowed = false;
        foreach ($roles as $role) {
            $allowed = $acl->isAllowed($role->slug, $controller, $action);
            if ($allowed) {
                break;
            }
        }
        if (!$allowed) {
            $role = $roles[0];
            if ($role && $role->slug === 'public') {
                
                // Si pas connecté, redirige vers la page de connexion avec le ?redirect
//                $uri = '/' . str_replace($this->url->getBaseUri(), null, $this->request->getURI());
//                header('Location:' . $this->url->get(array(
//                        'for' => 'backend-controller',
//                        'controller' => 'login'
//                    )) . (empty($uri)? null : '?redirect=' . rawurlencode($uri)));
//                exit(0);
                
                //@TODO why, just why /allowedController/not-found
                //dead pages = /backend/login/fndjsnfjkdsnjfds
                $this->response->redirect(trim($this->url->get(array(
                        'for' => 'backend-controller',
                        'controller' => 'login'
                    )) . (empty($uri)? null : '?redirect=' . rawurlencode($uri)), $this->url->getBaseUri()));
            }
            else {
                
                // Si connecté, ça veut dire qu'il n'est pas autorisé à voir la page en question
                $dispatcher->forward(array(
                    'controller' => 'errors',
                    'action' => 'unauthorized'
                ));
            }
            return false;
        }
    }
    
    /**
     *
     * Ajoute le format hyphen au resources
     * Dirty fix
     *
     * Exemple:
     * 'monProfil' => array('getAll');
     * 'errors' => array('notFound');
     *
     * Devient:
     * 'monProfil' => array('get-all', 'getAll');
     * 'mon-profil' => array('get-all', 'getAll', 'getall');
     * 'errors' => array('not-found', 'notFound', 'notfound');
     *
     * @param $resources
     */
    private function _fixCamelcaseHyphenResources(&$resources) {
        if (!empty($resources)) {
            foreach ($resources as $resourcesController => $resourcesActions) {
                $hyphenResourcesActions = array();
                foreach ($resourcesActions as $resourcesAction) {
                    $hyphenResourcesActions []= $this->_fixCamelcaseHyphen($resourcesAction);
                    $hyphenResourcesActions []= mb_strtolower($resourcesAction);
                }
                $resourcesActions = array_unique(array_merge($resourcesActions, $hyphenResourcesActions));
                $resources[$resourcesController] = $resourcesActions;
                $resources[$this->_fixCamelcaseHyphen($resourcesController)] = $resourcesActions;
            }
        }
    }
    private function _fixCamelcaseHyphen($string) {
        return mb_strtolower(str_replace('_', '-', Text::uncamelize($string)));
    }
}