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
use Zemit\Mvc\Model\AbstractTrait\AbstractMetaData;

trait PrimaryKeys
{
    use AbstractMetaData;
    use Attribute;
    
    /**
     * Get Primary Key Attributes from models MetaData
     */
    public function getPrimaryKeys(): array
    {
        assert($this instanceof ModelInterface);
        return $this->getModelsMetaData()->getPrimaryKeyAttributes($this);
    }
    
    /**
     * Get column map from models MetaData
     */
    public function getColumnMap(): array
    {
        assert($this instanceof ModelInterface);
        return $this->getModelsMetaData()->getColumnMap($this);
    }
    
    /**
     * Get an array of primary keys values
     */
    public function getPrimaryKeysValues(): array
    {
        $primaryKeys = $this->getPrimaryKeys();
        $columnMap = $this->getColumnMap();
        
        $ret = [];
        
        foreach ($primaryKeys as $primaryKey) {
            $attributeField = $columnMap[$primaryKey] ?? $primaryKey;
            $ret [$attributeField] = $this->getAttribute($attributeField);
        }
        
        return $ret;
    }
}
