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

use Zemit\Support\Helper;
use Zemit\Utils\Slug;

/**
 * {@inheritdoc}
 */
class View extends \Phalcon\Mvc\View
{
    private bool $minify = false;
    
    /**
     * True if content minifier is enabled
     */
    public function getMinify(): bool
    {
        return $this->minify;
    }
    
    /**
     * Set true to enable content minifier
     */
    public function setMinify(bool $minify): void
    {
        $this->minify = $minify;
    }
    
    /**
     * {@inheritdoc}
     */
    public function render(string $controllerName, string $actionName, array $params = [])
    {
        if (!$this->exists($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Helper::uncamelize($controllerName));
            $actionName = Slug::generate(Helper::uncamelize($actionName));
        }
        return parent::render($controllerName, $actionName, $params);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRender(string $controllerName, string $actionName, array $params = [], $configCallback = null): string
    {
        if (!$this->exists($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Helper::uncamelize($controllerName));
            $actionName = Slug::generate(Helper::uncamelize($actionName));
        }
        return parent::getRender($controllerName, $actionName, $params, $configCallback);
    }
    
    /**
     * {@inheritdoc}
     * Can also minify the content
     */
    public function getContent(?bool $minify = null): string
    {
        $content = parent::getContent();
        if ($minify ?? $this->getMinify()) {
            
            // Clean comments
            $content = preg_replace('/<!--([^\[|(<!)].*)/', null, $content);
            $content = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', null, $content);
            
            // Clean Whitespace
            $content = preg_replace('/\s{2,}/u', ' ', preg_replace('/\s{2,}/u', ' ', $content));
            $content = preg_replace('/(\r?\n)/', null, $content);
        }
        
        return $content ?? '';
    }
}
