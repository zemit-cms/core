<?php

namespace Zemit\Core\Mvc\Router;

use Phalcon\Mvc\Router\Group as RouterGroup;

class ModuleRoute extends RouterGroup
{
    public $locale = true;
    public $default = false;
    public $params = false;
    
    /**
     * ModuleRoute constructor.
     * The module routing is segmented in order to give more control over
     * the route for specific modules
     *
     * @param null $paths
     * @param bool $default
     * @param bool $locale
     * @param bool $params
     */
    public function __construct($paths = null, $default = false, $locale = true, $params = false)
    {
        $this->default = $default;
        $this->params = $params;
        $this->locale = $locale;
        parent::__construct($paths);
    }
    
    public function initialize()
    {
        $path = $this->getPaths();
        $module = $path['module'];
        $params = $this->params ? '/:params' : null;
        
        /**
         * /backend/
         * /fr/backend/
         * /fr-FR/backend/
         * /fr_FR/backend/
         */
        $this->locale = true;
        $this->setPrefix(($this->locale? '(/)?{locale:([a-z]{2,3}([\_\-][[:alnum:]]{1,8})?)?}' : null) . ($this->default ? null : '/' . $module));
        $prefixPos = $this->locale? 3 : 0;
        
        if ($this->default) {
            $module = 'zemit';
        }
        
        // /backend
        $this->add( '' . $params, [
        ])->setName($module);

        // /backend/users
        $this->add('/:controller' . $params, [
            'controller' => $prefixPos + 1,
        ])->setName($module);

        // /backend/user/list
        $this->add('/:controller/:action' . $params, [
            'controller' => $prefixPos + 1,
            'action' => $prefixPos + 2,
        ])->setName($module);

        // /backend/user/profile/jturbide
        $this->add( '/:controller/:action/([a-zA-Z0-9\_\-]+)' . $params, [
            'controller' => $prefixPos + 1,
            'action' => $prefixPos + 2,
            'slug' => $prefixPos + 3,
        ])->setName($module);

        // backend/user/edit/1
        $this->add( '/:controller/:action/:int' . $params, [
            'controller' => $prefixPos + 1,
            'action' => $prefixPos + 2,
            'int' => $prefixPos + 3,
        ])->setName($module);
    }
}
