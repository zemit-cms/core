<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\EntityInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractMetaData;

/**
 * The MetaData trait provides methods for retrieving metadata information about a model or entity.
 */
trait MetaData
{
    use AbstractMetaData;
    
    /**
     * Get the column mapping of the model
     *
     * @return array|null The column mapping of the model, or null if no mapping is defined
     */
    public function getColumnMap(): ?array
    {
        assert($this instanceof ModelInterface);
        return $this->getModelsMetaData()->getColumnMap($this);
    }
    
    /**
     * Retrieves the primary keys attributes of the model.
     *
     * @return array Array containing the primary keys of the model.
     */
    public function getPrimaryKeys(): array
    {
        assert($this instanceof ModelInterface);
        return $this->getModelsMetaData()->getPrimaryKeyAttributes($this);
    }
    
    /**
     * Retrieves the values of the primary keys attributes of the entity.
     *
     * @return array Array containing the values of the primary keys attributes of the entity.
     */
    public function getPrimaryKeysValues(): array
    {
        $ret = [];
        $columnMap = $this->getColumnMap() ?? [];
        
        assert($this instanceof EntityInterface);
        
        foreach ($this->getPrimaryKeys() as $primaryKey) {
            $attributeField = $columnMap[$primaryKey] ?? $primaryKey;
            $ret [$attributeField] = $this->readAttribute($attributeField);
        }
        
        return $ret;
    }
}
