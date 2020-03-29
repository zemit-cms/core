<?php

namespace Zemit\Mvc\Model;

trait User {
    
    protected static $_staticUser;
    
    protected function _setUser($namespace = __NAMESPACE__, $table = 'user', $session = 'user') {
        self::$_staticUser['namespace'] = $namespace;
        self::$_staticUser['table'] = $table;
        self::$_staticUser['session'] = $session;
    }
    
    protected function _getUser() {
        if (!isset(self::$_staticUser['user'])) {
            $session = $this->getDI()->getSession();
            self::$_staticUser['user'] = $session->get(self::$_staticUser['session']);
        }
        return self::$_staticUser['user'];
    }
    
}
