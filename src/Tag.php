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

use Phalcon\Escaper\EscaperInterface;
use Zemit\Assets\Manager;

/**
 * Class Tag
 * @inheritdoc
 * @package Zemit
 */
class Tag extends \Phalcon\Tag
{
    protected static $_assetsService = null;
    
    protected static $_meta = [
        [
            'name' => 'generator',
            'content' => 'Zemit'
        ]
    ];
    protected static $_link = [];
    protected static $_attr = [];
    
    /**
     * @return \Zemit\Escaper
     */
    public static function getEscaperService() : EscaperInterface
    {
        return parent::getEscaperService();
    }
    
    /**
     * Get the assets service from the default di
     * @return Manager
     */
    public static function getAssetsService() : \Phalcon\Assets\Manager
    {
        if (empty(self::$_assetsService)) {
            self::$_assetsService = self::getDI()->get('assets');
        }
        return self::$_assetsService;
    }
    
    /**
     * @inheritdoc parent::getTitle();
     *
     * @param bool $tags
     */
    public static function title($tags = true)
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
    
    /**
     * Forward to mb_sprintf function for the first layout of an array, then implode the values
     * Use the json_encode function to output the next dimension of the array
     * Otherwise use the htmlentities function to protect the html markup
     *
     * Usage example:
     * <div <?php Tag::implodeSprintf(['class' => 'class1 class2', 'id' => 'my-id', 'test' => ['test1', 'test2']], '%2$s="%1$s"', ' ');?>></div>
     * <div class="class1 class2" id="my-id" test="{['test1', 'test2']}"></div>
     *
     * @param $array
     * @param $implode
     * @param $sprintf
     *
     * @return string
     */
    public static function implodeSprintf($array, $sprintf = '%s', $implode = null)
    {
        $array = array_filter($array);
        return implode($implode, array_map(function ($value, $key) use ($sprintf) {
            [$value, $key] = self::escapeParam($value, $key);
            return sprintf($sprintf, $value, $key);
        }, $array, array_keys($array)));
    }
    
    /**
     * Escape CSS, JS, URL, ATTR for HTML from a value depending on the HTML attribute passed
     *
     * @param null|string|array|object $value Value to be escaped
     * @param null|string $attr Attribute to be escaped
     *
     * @return array Return the escaped value and attribute [$value, $attr]
     */
    public static function escapeParam($value = null, $attr = null, $glue = ' ')
    {
        $escaper = self::getEscaperService();
        $attr = $escaper->escapeHtmlAttr($attr);
        switch ($attr) {
            case 'css':
            case 'style':
                $value = $escaper->escapeCss($value);
                break;
            case 'js':
            case 'javascript':
                $value = $escaper->escapeJs($value);
                break;
            case 'href':
            case 'url':
                $value = $escaper->escapeUrl($value);
                break;
            default:
                // array escaper
                
                if (is_array($value)) {
                    if (isset($value[0]) && is_string($value[0])) {
                        foreach ($value as &$v) {
                            $v = $escaper->escapeHtmlAttr($v);
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
                    $value = $escaper->escapeHtmlAttr($value);
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
     * @param string|array $params Array of attrs, values and options to add into the tag html markup
     * @param mixed|string $html Anonymous function or string to generate the html markup inside the tag
     * @param string $htmlGlue Glue between the html markups
     *
     * @return string Return the html ready for output
     */
    public static function get($tag, $params = [], $html = null, $htmlGlue = null)
    {
        $tagParams = self::getParams($tag, $params);
        
        // Tag field is mandatory
        if (is_array($html)) {
            $html = implode('', $html);
        }
        
        $beforeHtml = '<' . $tag . $tagParams . ($html === false ? '/' : null) . '>';
        $afterHtml = ($html === false) ? null : '</' . $tag . '>';
        
        if (is_null($htmlGlue)) {
            $htmlGlue = $afterHtml . $beforeHtml;
        }
        
        // Execute the tag generator
        return $beforeHtml . self::getHtml($html, $htmlGlue) . $afterHtml . PHP_EOL;
    }
    
    public static function getTag()
    {
        return forward_static_call_array(__CLASS__ . '::get', func_get_args());
    }
    
    public static function tag()
    {
        echo forward_static_call_array(__CLASS__ . '::get', func_get_args());
    }
    
    /**
     * @param callable|array $html
     * @param null|string $htmlGlue
     *
     * @return string
     */
    public static function getHtml($html, $htmlGlue = null)
    {
        ob_start();
        $html = is_callable($html) ? $html() : $html;
        $output = ob_get_clean();
        $html = $html ?? $output;
        if (is_array($html)) {
            $html = implode($htmlGlue ?? '', $html);
        }
        return $html;
    }
    
    public static function html($html, $htmlGlue = null)
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
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
    public static function getParams($name = null, $params = [], $sprintf = ' %2$s="%1$s"', $glue = null)
    {
        // get by name if params is string, and params becomes empty
        if (is_string($params) && is_null($name)) {
            $name = $params;
            $params = [];
        } else {
            $params = is_array($params) ? $params : [$params => null];
        }
        if (!empty($name)) {
            if (is_string($name)) {
                $params = array_merge_recursive(self::getAttr($name), $params);
            } elseif (is_array($name)) {
                foreach ($name as $n) {
                    $params = array_merge_recursive(self::getAttr($n), $params);
                }
            }
        }
        return self::implodeSprintf($params, $sprintf, $glue);
    }
    
    public static function params($params = [], $name = null, $sprintf = ' %2$s="%1$s"', $glue = null)
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
    
    
    /**
     * Get the attrs value from the tag
     *
     * @param string|array $name Name or array of names of the tag attr(s) to retrieve
     *
     * @return array Return the attrs from the tag(s)
     */
    public static function getAttr($name = null, $merge = true)
    {
        $ret = [];
        
        if (is_null($name)) {
            $ret = self::$_attr;
        } elseif (is_array($name)) {
            foreach ($name as $n) {
                $ret [] = isset(self::$_attr[$n]) ? self::$_attr[$n] : null;
            }
        } else {
            $ret [] = isset(self::$_attr[$name]) ? self::$_attr[$name] : null;
        }
        
        // merge them together
        if ($merge) {
            $retMerge = [];
            foreach ($ret as $key => $val) {
                if (is_object($val)) {
                    $val = (array)$val;
                }
                if (isset($val)) {
                    $retMerge = array_merge_recursive($retMerge, $val);
                }
            }
        }
        
        return $retMerge ?? $ret;
    }
    
    public static function getAttrs()
    {
        return self::getAttr();
    }
    
    /**
     * Set a parameter name and save the options
     * Allow to merge with existing parameter
     *
     * @param $name
     * @param array $options
     * @param bool $merge
     *
     * @return array
     */
    public static function setAttr($name, $attrs = [], $merge = true)
    {
        $ret = null;
        if (is_array($name)) {
            $ret = [];
            foreach ($name as $n) {
                $ret [] = self::setAttrs([$n => $attrs], $merge);
            }
        } else {
            $ret = self::setAttrs([$name => $attrs], $merge);
        }
        return $ret;
    }
    
    /**
     * Allow to pass a multi-dimentional array to set the default attrs
     *
     * @param array|object|string $attrs Must be a multi-dimentional array Ex: ['body' => ['class' => 'class1']]
     * @param bool $merge Set true to not overwrite existing key
     *
     * @return array Return an array of the set tagsAttrs
     */
    public static function setAttrs($attrs = [], $merge = false)
    {
        $ret = [];
        if (is_object($attrs)) {
            $attrs = (array)$attrs;
        }
        if (is_string($attrs)) {
            if (!$merge || empty(self::$_attr[$attrs])) {
                $ret = self::$_attr[$attrs] = [];
            }
        } else {
            $ret = [];
            foreach ($attrs as $attrsKey => $attrsValue) {
                if (is_object($attrsValue)) {
                    $attrsValue = (array)$attrsValue;
                }
                if (!$merge || empty(self::$_attr[$attrsKey])) {
                    $ret [$attrsKey] = self::$_attr[$attrsKey] = $attrsValue;
                } else {
                    $ret [$attrsKey] = self::$_attr[$attrsKey] = array_merge_recursive(self::$_attr[$attrsKey], $attrsValue);
                }
            }
        }
        return $ret;
    }
    
    public static function resetAttrs()
    {
        self::$_attr = [];
    }
    
    
    public static function getHead()
    {
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
     *
     * @param string $charset
     */
    public static function setMetaCharset($charset = 'UTF-8')
    {
        self::removeMeta('charset');
        return self::addMeta('charset', $charset);
    }
    
    public static function setMetaProperty($property, $content)
    {
        self::removeMeta('property', $property);
        return self::addMeta('property', $property, $content);
    }
    
    public static function setMetaName($name, $content)
    {
        self::removeMeta('name', $name);
        return self::addMeta('name', $name, $content);
    }
    
    public static function addMeta($attr, $value, $content = null)
    {
        $meta = [$attr => $value];
        if (!empty($content)) {
            $meta['content'] = $content;
        }
        return self::addRawMeta($meta);
    }
    
    public static function addRawMeta($meta)
    {
        return self::$_meta [] = $meta;
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
     * @throws Exception if the options parameter is not an array
     *
     * @param string $attr Link tag attr
     * @param string $value Link tag attr value
     * @param array $options Link tag attrs and values
     */
    public static function addLink($attr, $value, $options = [])
    {
        self::addRawLink(array_merge($options, [$attr => $value]));
    }
    
    public static function addRawLink($link)
    {
        self::$_link [] = $link;
    }
    
    /**
     * Unset the meta from the attr and value, and the content if passed
     * Will remove all the contents if no content is passed
     *
     * @param string $attr The meta tag attr
     * @param string $value The meta tag value
     * @param string|null $content The meta tag content
     */
    public static function removeMeta($attr, $value = null, $content = null)
    {
        if (isset(self::$_meta[$attr]) && is_null($value)) {
            unset(self::$_meta[$attr]);
        } else {
            foreach (self::$_meta as $metaKey => $meta) {
                if (isset($meta[$attr]) && $meta[$attr] === $value) {
                    if (is_null($content) || isset($meta['content']) && $meta['content'] === $content) {
                        unset(self::$_meta[$metaKey]);
                    }
                }
            }
        }
    }
    
    /**
     * Get an html output of the head meta tags
     * @param string $glue Glue between each tag metas
     * @return string Html output of the head meta tags
     */
    public static function getMeta($glue = null)
    {
        $ret = [];
        foreach (self::$_meta as $meta) {
            $ret [] = self::get('meta', $meta, false);
        }
        return implode($glue ?? '', $ret);
    }
    
    /**
     * Echo html output of the head meta tags
     * @param string $glue Glue between each tag metas
     * @return void
     */
    public static function meta($glue = null)
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
    
    /**
     * Get an html output of the head link tags
     * @param string $glue Glue between each tag links
     * @return string Html output of the head link tags
     */
    public static function getLink($glue = null)
    {
        $ret = [];
        foreach (self::$_link as $link) {
            $ret [] = self::get('link', $link, false);
        }
        return implode($glue ?? '', $ret);
    }
    
    /**
     * Echo of the link meta
     * @param string $glue Glue between each tag links
     * @return void
     */
    public static function link($glue = null)
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
    
    /**
     * Return the CSS implicit output of that collection
     * @param string $collection CSS Collection string
     * @return string Return the CSS implicit output of that collection
     */
    public static function getCss(String $collection = null) : String
    {
        $assets = self::getAssetsService();
        $assets->useImplicitOutput(false);
        return $assets->outputCss($collection);
    }
    
    /**
     * Echo of the CSS implicit output of that collection
     * @param string $collection CSS Collection string
     * @return void
     */
    public static function css(String $collection = null) : Void
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
    
    /**
     * Return the JS implicit output of that collection
     * @param string $collection JS Collection string
     * @return string Return the JS implicit output of that collection
     */
    public static function getJs(String $collection = null) : String
    {
        $assets = self::getAssetsService();
        $assets->useImplicitOutput(false);
        return $assets->outputJs($collection);
    }
    
    /**
     * Echo of the JS implicit output of that collection
     * @param string $collection JS Collection string
     * @return void
     */
    public static function js(String $collection = null) : Void
    {
        echo forward_static_call_array(__CLASS__ . '::' . 'get' . ucfirst(__FUNCTION__), func_get_args());
    }
}
