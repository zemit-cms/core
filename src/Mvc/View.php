<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Mvc\View as MvcView;
use Phalcon\Text;
use Phalcon\Utils\Slug;

/**
 * Class View
 * - Ajoute la possibilité de minifier son HTML
 * - Ajoute la possibiltié de rechercher la bonne view à render si elle n'existe pas
 * -- ViewToSearch -> view_to_search -> view-to-search
 * @package GSS\Plugins\Mvc
 */
class View extends MvcView
{
    private $_minify;
    
    public function setMinify($minify)
    {
        $this->_minify = $minify ? true : false;
    }
    
    public function getMinify()
    {
        return $this->_minify ? true : false;
    }
    
    public function render($controllerName, $actionName, $params = [])
    {
        // Aucune vue trouver, tente le uncamelize, slug
        if (!$this->exists($controllerName . (empty($actionName)? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::render($controllerName, $actionName, $params);
    }
    
    public function getRender($controllerName, $actionName, $params = null, $configCallback = null) : String
    {
        // Aucune vue trouver, tente le uncamelize, slug
        if (!$this->exists($controllerName . (empty($actionName)? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::getRender($controllerName, $actionName, $params);
    }
    
    /**
     * Minify everything on production ENV only
     * @return String
     */
    public function getContent() : String
    {
        // Don't worry
        $content = parent::getContent();
        if ($this->getMinify()) {
            
            // Clean comments
            $content = preg_replace('/<!--([^\[|(<!)].*)/', null, $content);
            $content = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', null, $content);
            
            // Clean Whitespace
            $content = preg_replace('/\s{2,}/u', ' ', preg_replace('/\s{2,}/u', ' ', $content));
            $content = preg_replace('/(\r?\n)/', null, $content);
        }
        
        // Be happy
        return $content;
    }
    
}