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
use Zemit\Support\Slug;

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
    #[\Override]
    public function render(string $controllerName, string $actionName, array $params = []): \Phalcon\Mvc\View|bool
    {
        if (!$this->has($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Helper::uncamelize($controllerName));
            $actionName = Slug::generate(Helper::uncamelize($actionName));
        }
        return parent::render($controllerName, $actionName, $params);
    }
    
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function getRender(string $controllerName, string $actionName, array $params = [], $configCallback = null): string
    {
        if (!$this->has($controllerName . (empty($actionName) ? null : '/' . $actionName))) {
            $controllerName = Slug::generate(Helper::uncamelize($controllerName));
            $actionName = Slug::generate(Helper::uncamelize($actionName));
        }
        return parent::getRender($controllerName, $actionName, $params, $configCallback);
    }
    
    /**
     * {@inheritdoc}
     * Can also minify the content
     */
    #[\Override]
    public function getContent(?bool $minify = null): string
    {
        // Normalize content from parent to a string
        $content = parent::getContent();
        
        // Determine if minification should apply
        $shouldMinify = $minify ?? $this->getMinify();
        if (!$shouldMinify || $content === '') {
            return $content;
        }
    
        $result = preg_replace([
            '/<!--(?!\[if).*?-->/s', // remove HTML comments except conditional ones like <!--[if IE]>
            '/(?<!\S)\/\/[^\r\n]*/', // remove JS-style single-line comments
            '/\s{2,}/u', // collapse multiple spaces into one
            '/\r?\n/', // remove newlines
        ], ['', '', ' ', ''], $content);
        
        // Normalize and return
        return trim(is_array($result) ? implode('', $result) : (string) $result);
    }
}
