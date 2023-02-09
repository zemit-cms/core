<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Router;

use Phalcon\Mvc\Router\Group as RouterGroup;

/**
 * Class ModuleRoute
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Router
 */
class ModuleRoute extends RouterGroup
{
    public $locale;
    public $default;
    public $params;

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
    public function __construct($paths = null, $default = false, $locale = false, $params = true)
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

        if ($this->default) {
            $module = 'zemit';
        }

        /**
         * /admin/
         * /fr/admin/
         * /fr-FR/admin/
         * /fr_FR/admin/
         */
        $prefix = ($this->locale? '/{locale:([a-z]{2,3})}' : null) . ($this->default ? null : '/' . $module);
        $this->setPrefix($prefix);
        $prefixName = ($this->locale? 'locale-' : null) . $module;
        $prefixPos = $this->locale? 1 : 0;

        // /admin
        $this->add('' . $params, [
            'params' => $prefixPos + 1
        ])->setName($prefixName);

        // /admin/users
        $this->add('/:controller' . $params, [
            'controller' => $prefixPos + 1,
            'params' => $prefixPos + 2
        ])->setName($prefixName . '-controller');

        // /admin/user/list
        $this->add('/:controller/:action' . $params, [
            'controller' => $prefixPos + 1,
            'action' => $prefixPos + 2,
            'params' => $prefixPos + 3
        ])->setName($prefixName . '-controller-action');

        // /admin/user/profile/jturbide
//        $this->add('/:controller/:action/([a-zA-Z0-9\_\-]+)' . $params, [
//            'controller' => $prefixPos + 1,
//            'action' => $prefixPos + 2,
//            'slug' => $prefixPos + 3,
//            'params' => $prefixPos + 4
//        ])->setName($prefixName . '-controller-action-slug');
//
//        // /admin/user/edit/1
//        $this->add('/:controller/:action/:int' . $params, [
//            'controller' => $prefixPos + 1,
//            'action' => $prefixPos + 2,
//            'int' => $prefixPos + 3,
//            'params' => $prefixPos + 4
//        ])->setName($prefixName . '-controller-action-int');
    }
}
