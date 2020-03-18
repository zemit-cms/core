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

use Phalcon\Text;
use phpDocumentor\Reflection\Types\Boolean;
use Zemit\Utils\Slug;

/**
 * Class View
 * {@inheritdoc}
 * @package Zemit\Mvc
 */
class View extends \Phalcon\Mvc\View
{
    /**
     * @var bool Minify view
     */
    private $_minify;
    
    /**
     * @param $minify bool Set true to minify
     */
    public function setMinify($minify)
    {
        $this->_minify = $minify ? true : false;
    }
    
    /**
     * @return bool Minify
     */
    public function getMinify()
    {
        return $this->_minify ? true : false;
    }
    
    /**
     * {@inheritdoc}
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     *
     * @return bool|\Phalcon\Mvc\View
     * @throws \Zemit\Exception
     */
    public function render($controllerName, $actionName, $params = [])
    {
        // fix @todo check if we still have this issue
        if (!$this->exists($controllerName . (empty($actionName)? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::render($controllerName, $actionName, $params);
    }
    
    /**
     * {@inheritdoc}
     * @param string $controllerName
     * @param string $actionName
     * @param null $params
     * @param null $configCallback
     *
     * @return String
     * @throws \Zemit\Exception
     */
    public function getRender($controllerName, $actionName, $params = null, $configCallback = null) : String
    {
        // fix @todo check if we still have this issue
        if (!$this->exists($controllerName . (empty($actionName)? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::getRender($controllerName, $actionName, $params);
    }
    
    /**
     * {@inheritdoc}
     * Also automatically minify content
     * @return string
     */
    public function getContent() : string
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