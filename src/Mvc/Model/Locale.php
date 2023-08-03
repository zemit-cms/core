<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Zemit\Mvc\Model;

trait Locale
{
    /**
     * Returns the translation string of the given key
     *
     * @param array $placeholders
     * @param string $translateKey
     * @return string
     */
    public function _(string $translateKey, array $placeholders = []): string
    {
        $translate = $this->getDI()->get('translate');
        assert($translate instanceof \Phalcon\Translate\Adapter\AbstractAdapter);
        
        return $translate->_($translateKey, $placeholders);
    }
    
    /**
     * Magic caller to set or get localed named field automagically using the current locale
     * - Allow to call $this->getName{Fr|En|Sp|...}
     * - Allow to call $this->setName{Fr|En|Sp|...}
     *
     * @param string $method method name
     * @param array $arguments method arguments
     * @return mixed
     * @throws \Phalcon\Mvc\Model\Exception
     */
    public function __call(string $method, array $arguments)
    {
        $locale = $this->getDI()->get('locale');
        assert($locale instanceof \Zemit\Locale);
        
        $lang = $locale->getLocale() ?: 'en';
        
        if (mb_strrpos($method, ucfirst($lang)) !== mb_strlen($method) - mb_strlen($lang)) {
            $call = $method . ucfirst($lang);
            if (method_exists($this, $call)) {
                return $this->$call(...$arguments);
            }
        }
        
        return parent::__call($method, $arguments);
    }
    
    /**
     * Magic setter to set localed named field automatically using the current locale
     * - Allow to set $this->name{Fr|En|Sp|...} from missing name property
     *
     * @param string $property property name
     * @param mixed $value value to set
     * @return void
     */
    public function __set(string $property, $value)
    {
        $locale = $this->getDI()->get('locale');
        assert($locale instanceof \Zemit\Locale);
        
        $lang = $locale->getLocale();
        
        if (mb_strrpos($property, ucfirst($lang)) !== mb_strlen($property) - 2) {
            $set = $property . ucfirst($lang);
            
            if (property_exists($this, $set)) {
                $this->writeAttribute($set, $value);
                
                return;
            }
        }
        
        parent::__set($property, $value);
    }
    
    /**
     * Magic getter to get localed named field automatically using the current locale
     * - Allow to get $this->name{Fr|En|Sp|...} from missing name property
     *
     * @param string $property property name
     * @return mixed|null
     */
    public function __get(string $property)
    {
        $locale = $this->getDI()->get('locale');
        assert($locale instanceof \Zemit\Locale);
        
        $lang = $locale->getLocale();
        
        if (mb_strrpos($property, ucfirst($lang)) !== mb_strlen($property) - 2) {
            $set = $property . ucfirst($lang);
            
            if (property_exists($this, $set)) {
                return $this->readAttribute($set);
            }
        }
        
        return parent::__get($property);
    }
}
