<?php

namespace Zemit\Mvc\Model;

trait User {
    
    protected static $_staticUser;
    
    protected function _setUser($namespace = __NAMESPACE__, $table = 'user', $session = 'user', $userField) {
        self::$_staticUser['namespace'] = $namespace;
        self::$_staticUser['table'] = $table;
        self::$_staticUser['session'] = $session;
    
        if (property_exists($this, $userField)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($userField) {
                switch ($event->getType()) {
                    case 'beforeValidation':
                        $user = $this->_getUser();
                        if (property_exists($entity, $userField) && empty($entity->$userField) && $user) {
                            $entity->$userField = $user->id;
                        }
                        break;
                }
                return true;
            });
        }
    }
    
    protected function _getUser() {
        if (!isset(self::$_staticUser['user'])) {
            $session = $this->getDI()->getSession();
            self::$_staticUser['user'] = $session->get(self::$_staticUser['session']);
        }
        return self::$_staticUser['user'];
    }
    
}