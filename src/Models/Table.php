<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Models;

use Phalcon\Db\Adapter\Pdo\AbstractPdo;
use Phalcon\Db\Index;
use Zemit\Models\Abstracts\TableAbstract;
use Zemit\Models\Interfaces\TableInterface;
use Zemit\Db\Column as DbColumn;

/**
 * Class Table
 *
 * This class represents a Table object.
 * It extends the TableAbstract class and implements the TableInterface.
 */
class Table extends TableAbstract implements TableInterface
{
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
        
        $this->hasMany(['id', 'workspaceId'], Record::class, ['tableId', 'workspaceId'], ['alias' => 'RecordList']);
        $this->hasMany(['id', 'workspaceId'], Column::class, ['tableId', 'workspaceId'], ['alias' => 'ColumnList']);
    }
    
    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
    
    public function afterSave()
    {
        // Create or update the actual table after saving a Table entity
        $this->createOrUpdateRealTable();
    }
    
    public function createOrUpdateRealTable()
    {
        $db = $this->getDI()->get('dbd');
        assert($db instanceof AbstractPdo);
        
        $tableUuid = self::findFirstById($this->getId())->getUuid();
        
        
        // Check if the table already exists
        $existingTable = $db->tableExists($tableUuid);
        
        if (!$existingTable) {
            // Create a new table if it doesn't exist
            $db->createTable($tableUuid, '', [
                'columns' => [
                    new DbColumn(
                        'id',
                        [
                            'type' => DbColumn::TYPE_INTEGER,
                            'size' => 11,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'unique' => true,
                            'primary' => true,
                        ]
                    ),
                    new DbColumn(
                        'uuid',
                        [
                            'type' => DbColumn::TYPE_CHAR,
                            'size' => 36,
                            'notNull' => true,
                            'unique' => true,
                        ]
                    ),
                    new DbColumn(
                        'deleted',
                        [
                            'type' => DbColumn::TYPE_TINYINTEGER,
                            'size' => 1,
                            'notNull' => true,
                            'unique' => true,
                            'default' => 0,
                        ]
                    ),
                ],
            ]);
        }
        
        // Sync columns and indexes with the real table
        $this->syncColumnsAndIndexesWithRealTable();
    }
    
    public function syncColumnsAndIndexesWithRealTable()
    {
        $db = $this->getDI()->get('dbd');
        $tableUuid = self::findFirstById($this->getId())->getUuid();
        
        // Retrieve all columns associated with this table
        $columns = Column::findByTableId((int)$this->getId());
        
        // Fetch existing columns and indexes in one query
        $existingColumns = $db->describeColumns($tableUuid);
        $existingIndexes = $db->describeIndexes($tableUuid);
        
        $existingColumnNames = array_map(fn($col) => $col->getName(), $existingColumns);
        $existingIndexNames = array_keys($existingIndexes);
        
        // Sync Columns
        foreach ($columns as $column) {
            assert($column instanceof Column);
            
            $columnUuid = $column->getUuid();
            $columnType = $this->mapColumnType($column->getType());
            
            // Define the column structure based on its type
            $columnDefinition = new DbColumn(
                $columnUuid,
                [
                    'type' => $columnType['type'],
                    'size' => $columnType['size'] ?? null,
                    'notNull' => true,
                    'comment' => $column->getName()
                ]
            );
            
            // Check if the column already exists
            if (in_array($columnUuid, $existingColumnNames)) {
                // Modify existing column if it has changed
                $db->modifyColumn($tableUuid, '', $columnDefinition);
            }
            else {
                // Add the new column
                $db->addColumn($tableUuid, '', $columnDefinition);
            }
        }
        
        // Sync Indexes
//        $this->syncIndexes($tableUuid, $existingIndexes);
    }
    
    /**
     * Sync indexes (primary key, unique, and standard indexes) with the real table.
     */
    public function syncIndexes(string $tableUuid, array $existingIndexes)
    {
        $db = $this->getDI()->get('dbd');
        $columns = Column::findByTableId((int)$this->getId());
        
        $indexDefinitions = [];
        
        foreach ($columns as $column) {
            // Check for index settings (you can modify this according to your logic)
            if ($column->isUnique()) {
                // Add a unique index
                $indexDefinitions[$column->getUuid()] = new Index(
                    $column->getUuid() . '_unique',
                    [$column->getUuid()],
                    'UNIQUE'
                );
            }
            else if ($column->isIndexed()) {
                // Add a standard index
                $indexDefinitions[$column->getUuid()] = new Index(
                    $column->getUuid() . '_index',
                    [$column->getUuid()]
                );
            }
        }
        
        // Sync new and modified indexes
        foreach ($indexDefinitions as $indexName => $indexDefinition) {
            if (!array_key_exists($indexName, $existingIndexes)) {
                $db->addIndex($tableUuid, $tableUuid, $indexDefinition);
            }
        }
    }
    
    /**
     * Map column type from model to Phalcon\Db\Column types.
     */
    public function mapColumnType(string $type): array
    {
        return match ($type) {
            'text' => ['type' => DbColumn::TYPE_VARCHAR, 'size' => 255],
            'number' => ['type' => DbColumn::TYPE_INTEGER],
            'boolean' => ['type' => DbColumn::TYPE_BOOLEAN],
            'date' => ['type' => DbColumn::TYPE_DATE],
            'float' => ['type' => DbColumn::TYPE_FLOAT],
            'double' => ['type' => DbColumn::TYPE_DOUBLE],
            'timestamp' => ['type' => DbColumn::TYPE_TIMESTAMP],
            default => ['type' => DbColumn::TYPE_VARCHAR, 'size' => 255],
        };
    }
}
