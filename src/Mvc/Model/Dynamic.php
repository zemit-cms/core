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

use Phalcon\Cache\Adapter\Apcu;
use Phalcon\Mvc\Model\MetaData;
use Zemit\Mvc\Model;
use Zemit\Support\Utils;

/**
 * @todo, fix phalcon models meta data instead of just resetting it
 */
class Dynamic extends Model
{
    protected array $_metaData = [];
    protected array $_columnMap = [];
    
    #[\Override]
    public function initialize(): void
    {
        $this->setConnectionService('dbd');
        $this->setReadConnectionService('dbd');
        $this->setWriteConnectionService('dbd');
        
        // force delete cache for dynamic models
        // @todo find a better way to handle dynamic models using
        // meta data strategy or by overriding models meta data caching adapter etc.
        // ->reset didn't work for unknown reason
        $modelsMetaData = $this->getModelsMetaData();
        assert($modelsMetaData instanceof MetaData);
        $adapter = $modelsMetaData->getAdapter();
        if ($adapter instanceof Apcu) {
            $lowerClassName = strtolower(Utils::getName($this));
            $adapter->delete('meta-' . $lowerClassName);
            $adapter->delete('map-' . $lowerClassName);
        }
        
        parent::initialize();
    }
    
    /**
     * Set the source table dynamically.
     */
    public function setDynamicSource(string $table): void
    {
        $this->setSource($table);
    }
    
    /**
     * Sets dynamic metadata for the object.
     */
    public function setDynamicMetaData(array $metaData): void
    {
        $this->_metaData = $metaData;
    }
    
    /**
     * Set the column mapping dynamically.
     */
    public function setDynamicColumnMap(array $map): void
    {
        $this->_columnMap = $map;
    }
    
    /**
     * Retrieves the metadata associated with the object.
     *
     * @return array The metadata as an associative array. Returns an empty array if no metadata is set.
     */
//    public function metaData(): array
//    {
//        return $this->_metaData ??= $this->getModelsMetaData()->readMetaData($this);
//    }
    
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
