<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Phalcon\Tag as PhalconTag;
use Phalcon\Html\Escaper;
use Phalcon\Html\Escaper\EscaperInterface;
use Zemit\Assets\Manager;

/**
 * {@inheritDoc}
 */
class Tag extends PhalconTag
{
    protected static array $meta = [];
    
    protected static array $link = [];
    
    protected static array $attr = [];
    
    protected static ?Manager $assetsService = null;
    
    public static function getAssets(?array $params = null): ?Manager
    {
        self::$assetsService ??= self::getDI()->get('assets', $params);
        return self::$assetsService;
    }
    
    /**
     * Returns an Assets service from the default DI
     */
    public static function getAssetsService(): ?Manager
    {
        self::$assetsService ??= self::getDI()->getService('assets');
        return self::$assetsService;
    }
    
    /**
     * Set the Asset Service for Tag
     */
    public static function setAssetsService(?Manager $assets): void
    {
        self::$assetsService = $assets;
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getEscaper(array $params): ?EscaperInterface
    {
        @$escaper = PhalconTag::getEscaper($params);
        assert($escaper instanceof Escaper);
        return $escaper;
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getEscaperService(): EscaperInterface
    {
        @$escaper = PhalconTag::getEscaperService();
        assert($escaper instanceof Escaper);
        return $escaper;
    }
    
    /**
     * Echo the current document title. The title will be automatically escaped.
     */
    public static function title(bool $prepend = true, bool $append = true): void
    {
        echo self::getTitle($prepend, $append);
    }
    
    /**
     * Forward to mb_sprintf function for the first layout of an array, then implode the values
     * Use the json_encode function to output the next dimension of the array
     * Otherwise use the htmlentities function to protect the html markup
     *
     * Usage example:
     * <div <?php Tag::implodeSprintf(['class' => 'class1 class2', 'id' => 'my-id', 'test' => ['test1', 'test2']], '%2$s="%1$s"', ' ');?>></div>
     * <div class="class1 class2" id="my-id" test="{['test1', 'test2']}"></div>
     */
    public static function implodeSprintf(array $array, string $format = '%s', ?string $glue = null): string
    {
        $array = array_filter($array);
        return implode($glue ?? '', array_map(function ($value, $key) use ($format) {
            [$value, $key] = self::escapeParam($value, $key);
            return sprintf($format, $value, $key);
        }, $array, array_keys($array)));
    }
    
    /**
     * Escape CSS, JS, URL, ATTR for HTML from a value depending on the HTML attribute passed
     *
     * @param null|string|array|object $value Value to be escaped
     * @param ?string $attr Attribute to be escaped
     *
     * @return array Return the escaped value and attribute [$value, $attr]
     */
    public static function escapeParam($value = null, ?string $attr = null, string $glue = ' '): array
    {
        $escaper = self::getEscaperService();
        assert($escaper instanceof \Zemit\Html\Escaper);
        
        $attr = $escaper->attributes($attr);
        switch ($attr) {
            case 'css':
            case 'style':
                $value = $escaper->css($value);
                break;
            
            case 'js':
            case 'javascript':
                $value = $escaper->js($value);
                break;
            
            case 'href':
            case 'url':
                $value = $escaper->url($value);
                break;
            
            default:
                // array escaper
                if (is_array($value)) {
                    if (isset($value[0]) && is_string($value[0])) {
                        foreach ($value as &$v) {
                            $v = $escaper->attributes($v);
                        }
                        $value = implode($glue, $value);
                    }
                    
                    // deep array escaper
                    else {
                        $value = $escaper->escapeJson(json_encode($value));
                    }
                }
                // other object escaper
                elseif (is_object($value)) {
                    $value = $escaper->escapeJson(json_encode($value));
                }
                // default escaper
                else {
                    $value = $escaper->attributes($value);
                }
                break;
        }
        
        return [$value, $attr];
    }
    
    /**
     *
     * Use example:
     * Tag::get('div', ['class' => 'class1 class2'], ['content1', 'content2']);
     * <div class="class1 class2">content1</div>
     * <div class="class1 class2">content2</div>
     *
     * Tag::get('div', ['class' => 'class1 class2'], ['content1', 'content2'], ' ');
     * <div class="class1 class2">content1 content2</div>
     *
     * More complex use example
     * Tag::get('footer', ['class' => 'my-footer-class'], [
     *      Tag::get('ul', ['class' => 'my-ul-class'], [
     *          Tag::get('li', ['class'] => 'my-li-class', ['content1', 'content2']),
     *          Tag::get('li', ['class'] => 'my-li-class-2', ['content3', 'content4']),
     *      ],
     *      Tag::get('ul', ['class' => 'my-ul-class-2'], [
     *          Tag::get('li', ['class'] => 'my-li-class-3', ['content5', 'content6']),
     *      ], ''
     * ], ' ');
     * <footer class="my-footer-class">
     *      <ul class="my-ul-class">
     *          <li class="my-li-class">content1</li>
     *          <li class="my-li-class">content2</li>
     *          <li class="my-li-class-2">content3</li>
     *          <li class="my-li-class-2">content4</li>
     *      </ul>
     *      <ul class="my-ul-class-2">
     *          <li class="my-li-class-3">content5 content6</li>
     *      </ul>
     * </div>
     *
     * @param string $tag Tag name to generate
     * @param array $params Array of attrs, values and options to add into the tag html markup
     * @param array $html Anonymous function or string to generate the html markup inside the tag
     * @param ?string $glue Glue between the html markups
     *
     * @return string Return the html ready for output
     */
    public static function get(string $tag, array $params = [], array $html = [], ?string $glue = null): string
    {
        $tagParams = self::getTagParams($tag, $params);
        
        // Tag field is mandatory
        $content = implode('', $html);
        
        $beforeHtml = '<' . $tag . $tagParams . (empty($content) ? '/' : '') . '>';
        $afterHtml = (empty($content)) ? '' : '</' . $tag . '>';
        if (is_null($glue)) {
            $glue = $afterHtml . $beforeHtml;
        }
        
        // Execute the tag generator
        return $beforeHtml . implode($glue ?? '', $html) . $afterHtml . PHP_EOL;
    }
    
    public static function getTag(string $tag, array $params = [], array $html = [], ?string $glue = null): string
    {
        return self::get($tag, $params, $html, $glue);
    }
    
    public static function tag(string $tag, array $params = [], array $html = [], ?string $glue = null): void
    {
        echo self::get($tag, $params, $html, $glue);
    }
    
    public static function getTagParams(string $tag, array $params = [], string $format = ' %2$s="%1$s"', ?string $glue = null): string
    {
        return self::getParams(array_merge(self::getAttr($tag), $params), $format, $glue);
    }
    
    public static function tagParams(string $tag, array $params = [], string $format = ' %2$s="%1$s"', ?string $glue = null): void
    {
        echo self::getTagParams($tag, $params, $format, $glue);
    }
    
    /**
     * Will sprintf an array_map of the array and then implode it with a ' ' glue
     * - Escape attrs and values during the process
     *
     * Use example:
     * Tag::getParams(['class' => 'class1 class2', 'id' => 'my-id'])
     * class="class1 class2" id="my-id"
     *
     * Tag::getParams(['class' => 'class1 class2', 'id' => 'my-id'])
     * class="class1 class2" id="my-id"
     *
     * @param string|array $params Array to implode & sprintf
     *
     * @return string Return the imploded sprintf "%2$s="%1$s" from an array
     */
    public static function getParams(array $params = [], string $format = ' %2$s="%1$s"', ?string $glue = null): string
    {
        foreach ($params as $param) {
            $params = array_merge_recursive(self::getAttr($param), $params);
        }
        $params = array_filter($params, 'is_string', ARRAY_FILTER_USE_KEY);
        return self::implodeSprintf($params, $format, $glue);
    }
    
    public static function params(array $params = [], string $format = ' %2$s="%1$s"', ?string $glue = null): void
    {
        echo self::getParams($params, $format, $glue);
    }
    
    
    /**
     * Get the attrs value from the tag
     */
    public static function getAttr(string $name): array
    {
        return self::getAttrs()[$name] ?? [];
    }
    
    /**
     * Get the attributes
     */
    public static function getAttrs(): array
    {
        return self::$attr;
    }
    
    /**
     * Set a parameter name and save the options
     * Allow to merge with existing parameter
     */
    public static function setAttr(string $name, array $attrs = [], bool $merge = true): void
    {
        self::setAttrs([$name => $attrs], $merge);
    }
    
    /**
     * Allow to pass a multidimensional array to set the default attrs
     * @param array $attrs Must be a multidimensional array Ex: ['body' => ['class' => 'class1']]
     */
    public static function setAttrs(array $attrs = [], bool $merge = false): array
    {
        $ret = [];
        foreach ($attrs as $attrsKey => $attrsValue) {
            if (!$merge || empty(self::$attr[$attrsKey])) {
                $ret [$attrsKey] = self::$attr[$attrsKey] = $attrsValue;
            }
            else {
                $ret [$attrsKey] = self::$attr[$attrsKey] = array_merge_recursive(self::$attr[$attrsKey], $attrsValue);
            }
        }
        return $ret;
    }
    
    /**
     * Remove everything from attrs
     */
    public static function resetAttrs(): void
    {
        self::$attr = [];
    }
    
    
    /**
     * @todo
     */
    public static function getHead(): ?string
    {
        return '';
    }
    
    /**
     * Set the meta charset value
     * Specifies the character encoding for the HTML document.
     *
     * Use example:
     * Tag::setMetaCharset('UTF-8');
     * Tag::meta('charset', 'UTF-8');
     * <meta charset="UTF-8">
     *
     * Common values:
     *      UTF-8 - Character encoding for Unicode
     *      ISO-8859-1 - Character encoding for the Latin alphabet
     * In theory, any character encoding can be used, but no browser understands all of them. The more widely a character encoding is used, the better the chance that a browser will understand it.
     * To view all available character encodings, look at IANA character sets.
     * http://www.iana.org/assignments/character-sets/character-sets.xhtml
     *
     * For more information about the charset values, please visit this documentation below
     * https://www.w3schools.com/tags/att_meta_charset.asp
     */
    public static function setMetaCharset(string $charset = 'UTF-8'): void
    {
        self::removeMeta('charset');
        self::addMeta('charset', $charset);
    }
    
    /**
     * Set Meta by property
     */
    public static function setMetaProperty(string $property, ?string $content = null): void
    {
        self::removeMeta('property', $property);
        self::addMeta('property', $property, $content);
    }
    
    /**
     * Set Meta Name
     */
    public static function setMetaName(string $name, ?string $content = null): void
    {
        self::removeMeta('name', $name);
        self::addMeta('name', $name, $content);
    }
    
    /**
     * Add meta
     */
    public static function addMeta(string $attr, string $value, ?string $content = null): void
    {
        $meta = [$attr => $value];
        if (!empty($content)) {
            $meta['content'] = $content;
        }
        self::addRawMeta($meta);
    }
    
    /**
     * ADd raw meta
     */
    public static function addRawMeta(array $meta): void
    {
        self::$meta [] = $meta;
    }
    
    /**
     * Add a new link tag
     *
     * Use example:
     * Tag::addLink('rel', 'alternate', ['type' => 'application/atom+xml', 'title' => 'Zemit CMS', 'href' => '/blog/news/atom"']);
     * <link rel="alternate" type="application/atom+xml" title="Zemit CMS News" href="/blog/news/atom">
     *
     * For more information about the attr, values and other options please visite the w3schools documentation below
     * https://www.w3schools.com/tags/tag_link.asp
     *
     * @param string $attr Link tag attr
     * @param string $value Link tag attr value
     * @param array $options Link tag attrs and values
     *
     */
    public static function addLink(string $attr, string $value, array $options = []): void
    {
        self::addRawLink(array_merge($options, [$attr => $value]));
    }
    
    /**
     * Add raw link
     */
    public static function addRawLink(array $link): void
    {
        self::$link [] = $link;
    }
    
    /**
     * Unset the meta from the attr and value, and the content if passed
     * Will remove all the contents if no content is passed
     */
    public static function removeMeta(string $attr, ?string $value = null, ?string $content = null): void
    {
        if (isset(self::$meta[$attr]) && is_null($value)) {
            unset(self::$meta[$attr]);
        }
        else {
            foreach (self::$meta as $metaKey => $meta) {
                if (isset($meta[$attr]) && $meta[$attr] === $value) {
                    if (is_null($content) || isset($meta['content']) && $meta['content'] === $content) {
                        unset(self::$meta[$metaKey]);
                    }
                }
            }
        }
    }
    
    /**
     * Get html output of the head meta tags
     */
    public static function getMeta(?string $glue = null): ?string
    {
        $ret = [];
        foreach (self::$meta as $meta) {
            $ret [] = self::get('meta', $meta);
        }
        return implode($glue ?? '', $ret);
    }
    
    /**
     * Echo html output of the head meta tags
     */
    public static function meta(?string $glue = null): void
    {
        echo self::getMeta($glue);
    }
    
    /**
     * Get an html output of the head link tags
     */
    public static function getLink(?string $glue = null): ?string
    {
        $ret = [];
        foreach (self::$link as $link) {
            $ret [] = self::get('link', $link);
        }
        return implode($glue ?? '', $ret);
    }
    
    /**
     * Echo of the link meta
     */
    public static function link(?string $glue = null): void
    {
        echo self::getLink($glue);
    }
    
    /**
     * Return the CSS implicit output of that collection
     */
    public static function getCss(?string $collection = null): ?string
    {
        $assets = self::getAssets();
        $assets->useImplicitOutput(false);
        return $assets->outputCss($collection);
    }
    
    /**
     * Echo of the CSS implicit output of that collection
     */
    public static function css(?string $collection = null): void
    {
        echo self::getCss($collection);
    }
    
    /**
     * Return the JS implicit output of that collection
     */
    public static function getJs(?string $collection = null): ?string
    {
        $assets = self::getAssets();
        $assets->useImplicitOutput(false);
        return $assets->outputJs($collection);
    }
    
    /**
     * Echo of the JS implicit output of that collection
     */
    public static function js(?string $collection = null): void
    {
        echo self::getJs($collection);
    }
}
