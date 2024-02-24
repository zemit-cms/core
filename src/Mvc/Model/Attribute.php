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

use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractEntity;
use Zemit\Mvc\Model\AbstractTrait\AbstractMetaData;
use Zemit\Support\Helper;

trait Attribute
{
    use AbstractMetaData;
    use AbstractEntity;
    
    /**
     * Method to get attribute from getters or the readAttribute
     * @param string $attribute
     * @return mixed|null
     */
    public function getAttribute(string $attribute)
    {
        assert($this instanceof ModelInterface);
        if ($this->getModelsMetaData()->hasAttribute($this, $attribute)) {
            
            $method = 'get' . ucfirst(Helper::camelize($attribute));
            if (method_exists($this, $method)) {
                return $this->$method();
            }
            
            return $this->readAttribute($attribute);
        }
        
        return null;
    }
    
    /**
     * Method to set attribute from setter or the writeAttribute
     * @param string $attribute
     * @param mixed|null $value
     * @return mixed|null
     */
    public function setAttribute(string $attribute, $value): void
    {
        assert($this instanceof ModelInterface);
        if ($this->getModelsMetaData()->hasAttribute($this, $attribute)) {
            
            $method = 'set' . ucfirst(Helper::camelize($attribute));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
            
            $this->writeAttribute($attribute, $value);
        }
    }
}
