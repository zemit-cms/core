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

use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Mvc\Model\MetaData\Memory;
use Zemit\Mvc\Model;

/**
 * @todo, fix phalcon models meta data instead of just resetting it
 */
class Dynamic extends Model
{
    protected $_columnMap = [];
    
    public function initialize(): void
    {
        $this->setConnectionService('dbd');
        $this->setReadConnectionService('dbd');
        $this->setWriteConnectionService('dbd');
        parent::initialize();
    }
    
    /**
     * Set the source table dynamically.
     */
    public function setDynamicSource(string $table): void
    {
        $this->setSource($table);
        $this->getModelsMetaData()->reset();
    }
    
    /**
     * Set the column mapping dynamically.
     */
    public function setDynamicColumnMap(array $map): void
    {
        $this->_columnMap = $map;
        $this->getModelsMetaData()->reset();
    }
    
    /**
     * Dynamically set the column mapping.
     * Phalcon uses this to map database columns to model attributes.
     */
    public function columnMap(): array
    {
        if (empty($this->_columnMap)) {
            // Dynamically load column names from the database (or handle them dynamically)
            $metadata = $this->getModelsMetaData();
            $dataTypes = $metadata->getDataTypes($this);
            $columnMap = array_keys($dataTypes);
            
            // Store and return the dynamically generated column map
            $this->_columnMap = array_combine($columnMap, $columnMap);
        }
        
        return $this->_columnMap;
    }
    
    /**
     * Create a dynamic instance with a specific source and column map.
     */
    public static function createInstance(string $source, array $columnMap = []): Dynamic
    {
        $instance = new self();
        $instance->setDynamicSource($source);
        if (!empty($columnMap)) {
            $instance->setDynamicColumnMap($columnMap);
        }
        return $instance;
    }
}
