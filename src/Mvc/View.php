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
use Zemit\Utils\Slug;

/**
 * {@inheritdoc}
 */
class View extends \Phalcon\Mvc\View
{
    private bool $minify = false;
    
    public function getMinify(): bool
    {
        return $this->minify;
    }
    
    public function setMinify(bool $minify): void
    {
        $this->minify = $minify;
    }
    
    /**
     * {@inheritdoc}
     */
    public function render(string $controllerName, string $actionName, array $params = []): bool|View
    {
        if (!$this->exists($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::render($controllerName, $actionName, $params);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRender(string $controllerName, string $actionName, array $params = [], $configCallback = null): string
    {
        if (!$this->exists($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Text::uncamelize($controllerName));
            $actionName = Slug::generate(Text::uncamelize($actionName));
        }
        return parent::getRender($controllerName, $actionName, $params, $configCallback);
    }
    
    /**
     * {@inheritdoc}
     * Also minify content
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
