<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Mvc\Model\Traits;

use Phalcon\Mvc\ModelInterface;
use PhalconKit\Mvc\Model\Traits\Abstracts\AbstractEntity;
use PhalconKit\Mvc\Model\Traits\Abstracts\AbstractMetaData;
use PhalconKit\Support\Helper;

/**
 * This trait provides methods to get and set attributes in a model using the get/set methods
 */
trait Attribute
{
    use AbstractMetaData;
    use AbstractEntity;
    
    /**
     * Returns the value of the specified attribute.
     *
     * @param string $attribute The name of the attribute.
     *
     * @return mixed|null The value of the specified attribute if it exists, otherwise null.
     */
    public function getAttribute(string $attribute): mixed
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
     * Sets the value of the specified attribute.
     *
     * @param string $attribute The name of the attribute.
     * @param mixed $value The value to be set for the attribute.
     *
     * @return void
     */
    public function setAttribute(string $attribute, mixed $value): void
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
