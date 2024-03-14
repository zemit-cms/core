<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks\Traits;

use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Db\Column;
use Phalcon\Db\ColumnInterface;
use Zemit\Support\Helper;

/**
 * Trait DescribesTrait
 *
 * This trait provides methods for describing table columns, references,
 * indexes, and determining the data type of columns. It also provides
 * methods for retrieving default values of columns, generating property
 * names based on column names, and generating table names based on
 * original names.
 */
trait DescribesTrait
{
    // @todo abstract injectable here
    
    protected array $cachedColumns = [];
    protected array $cachedIndexes = [];
    protected array $cachedReferences = [];
    
    /**
     * Retrieves the columns of a given table.
     * @param string $table The name of the table to describe the columns.
     * @return array An array of columns for the specified table.
     */
    public function describeColumns(string $table): array
    {
        return $this->cachedColumns[$table] ??= $this->db->describeColumns($table);
    }
    
    /**
     * Retrieves the references of a given table.
     * @param string $table The name of the table to describe the references.
     * @return array An array of references for the specified table.
     */
    public function describeReferences(string $table): array
    {
        return $this->cachedReferences[$table] ??= $this->db->describeReferences($table);
    }
    
    /**
     * Retrieves the indexes of a given table.
     * @param string $table The name of the table to describe the indexes.
     * @return array An array of indexes for the specified table.
     */
    public function describeIndexes(string $table): array
    {
        return $this->cachedIndexes[$table] ??= $this->db->describeIndexes($table);
    }
    
    /**
     * Determines if a value is a Phalcon DB RawValue.
     * @param string|null $defaultValue The value to check.
     * @return bool Returns true if the value is a raw value, false otherwise.
     */
    public function isRawValue(string $defaultValue = null): bool
    {
        return match ($defaultValue) {
            'CURRENT_TIMESTAMP',
            'NOW()',
            'CURDATE()',
            'CURTIME()',
            'UNIX_TIMESTAMP()',
            'RAND()',
            'UUID()',
            'USER()',
            'CONNECTION_ID()'
            => true,
            
            default
            => false,
        };
    }
    
    /**
     * Determines the PHP data type of column.
     *
     * @param ColumnInterface $column The column to check.
     *
     * @return string The data type of the column. Possible values are:
     *                - 'bool' for boolean columns.
     *                - 'int' for integer columns.
     *                - 'float' for decimal or float columns.
     *                - 'double' for double columns.
     *                - 'string' for all other column types.
     */
    public function getColumnType(ColumnInterface $column): string
    {
        return match ($column->getType()) {
            Column::TYPE_BOOLEAN
            => 'bool',
            
            Column::TYPE_TIMESTAMP,
            Column::TYPE_BIGINTEGER,
            Column::TYPE_MEDIUMINTEGER,
            Column::TYPE_SMALLINTEGER,
            Column::TYPE_TINYINTEGER,
            Column::TYPE_INTEGER,
            Column::TYPE_BIT
            => 'int',
            
            Column::TYPE_DECIMAL,
            Column::TYPE_FLOAT
            => 'float',
            
            Column::TYPE_DOUBLE
            => 'double',
            
            default
            => 'string',
        };
    }
    
    /**
     * Retrieves the default value for a column.
     * @param ColumnInterface $column The column object to retrieve the default value from.
     * @return string|int|bool|float|null Returns the default value of the column as a string, integer, boolean, float, or null based on the column type.
     */
    public function getDefaultValue(ColumnInterface $column): string|int|bool|float|null
    {
        $columnDefault = $column->getDefault();
        if (!isset($columnDefault)) {
            return null;
        }
        
        $type = $this->getColumnType($column);
        return match ($type) {
            'bool' => (bool)$columnDefault,
            'int' => (int)$columnDefault,
            'double' => (double)$columnDefault,
            'float' => (float)$columnDefault,
            default => ($this->isRawValue($columnDefault) ? null
                : '\'' . addslashes((string)$columnDefault) . '\''),
        };
    }
    
    /**
     * Retrieves the property name based on the given name.
     * @param string $name The name from which to retrieve the property name.
     * @return string Returns the property name as a string.
     */
    public function getPropertyName(string $name): string
    {
        return lcfirst(
            Helper::camelize(
                Helper::uncamelize(
                    $name
                )
            )
        );
    }
    
    /**
     * Retrieves the table name based on the given name.
     * @param string $name The original name of the table.
     * @return string Returns the table name with the first letter capitalized and all other letters unchanged.
     */
    public function getTableName(string $name): string
    {
        return ucfirst(
            Helper::camelize(
                Helper::uncamelize(
                    $name
                )
            )
        );
    }
}
