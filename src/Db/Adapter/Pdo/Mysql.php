<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Adapter\Pdo;

use Phalcon\Db\Column;

class Mysql extends \Phalcon\Db\Adapter\Pdo\Mysql
{
    #[\Override]
    public function describeColumns(string $table, ?string $schema = null): array
    {
        $definitions = parent::describeColumns($table, $schema);
        
        if (Column::TYPE_TINYINTEGER !== Column::TYPE_BINARY) {
            return $definitions;
        }
        
        foreach ($definitions as $definitionKey => $definition) {
            
            if ($definition->getType() === Column::TYPE_TINYINTEGER && !$definition->isNumeric()) {
                // probably a binary at this point
                
                $newDefinition = [];
                
                // protected to public
                $prefix = chr(0) . '*' . chr(0);
                foreach ((array)$definition as $key => $value) {
                    $newDefinition[str_replace($prefix, '', $key)] = $value;
                }
                
                $newDefinition['bindType'] = Column::BIND_PARAM_BLOB;
                $newDefinition['type'] = Column::TYPE_VARBINARY;
                unset($newDefinition['scale']);
                
                // reset definition
                $definitions[$definitionKey] = new Column($definition->getName(), $newDefinition);
            }
        }
        
        return $definitions;
    }
    
    /**
     * Overrides the executePrepared method to rewrite duplicate placeholders.
     *
     * @param \PDOStatement $statement The original PDO statement.
     * @param array $placeholders An array of bind values.
     * @param array $dataTypes An array of bind types.
     *
     * @return \PDOStatement
     */
    #[\Override]
    public function executePrepared(\PDOStatement $statement, array $placeholders, $dataTypes): \PDOStatement
    {
        // Get the original SQL from the statement.
        $sql = $statement->queryString;
        
        // Rewrite the SQL to ensure unique parameter names and update the placeholders.
        [$newSql, $newPlaceholders, $newDataTypes] = $this->rewriteQueryPlaceholders($sql, $placeholders, $dataTypes);
        
        // Prepare a new statement with the rewritten SQL.
        $newStatement = $this->pdo->prepare($newSql);
        
        // Call parent's executePrepared with the new statement.
        return parent::executePrepared($newStatement, $newPlaceholders, $newDataTypes);
    }
    
    /**
     * Rewrites an SQL query by replacing duplicate named placeholders with unique ones.
     *
     * This function scans the SQL for named placeholders (like :paramName) and for every
     * duplicate occurrence (beyond the first), it appends a unique suffix (e.g. :paramName_2)
     * and duplicates the corresponding bind value and type.
     *
     * It also handles cases where the bind arrays use keys without a leading colon.
     *
     * @param string $sql The original SQL query.
     * @param array $bind The bind values array.
     * @param array $bindTypes The bind types array.
     *
     * @return array            An array containing the new SQL, the new bind values, and the new bind types.
     */
    public function rewriteQueryPlaceholders(string $sql, array $bind, array $bindTypes): array
    {
        // Pattern to match named placeholders, e.g. ":paramName"
        $pattern = '/(:[a-zA-Z0-9_]+)/';
        $placeholderCount = [];
        
        $newSql = preg_replace_callback($pattern, function ($matches) use (&$placeholderCount, &$bind, &$bindTypes) {
            $placeholder = $matches[1]; // e.g. ":myParam"
            
            // Determine the key used in the bind arrays.
            // Some arrays use keys with the colon, others without.
            $originalKey = array_key_exists($placeholder, $bind)
                ? $placeholder
                : ltrim($placeholder, ':');
            
            // If this is the first occurrence, leave it as is.
            if (!isset($placeholderCount[$placeholder])) {
                $placeholderCount[$placeholder] = 1;
                return $placeholder;
            }
            
            // For subsequent occurrences, increment the counter and generate a unique placeholder.
            $placeholderCount[$placeholder]++;
            $newPlaceholder = $placeholder . '_' . $placeholderCount[$placeholder];
            
            // Adjust the new key to match the original style.
            $newKey = (str_starts_with($originalKey, ':')) ? $newPlaceholder : ltrim($newPlaceholder, ':');
            
            // Duplicate the bind value and type for the new placeholder.
            if (isset($bind[$originalKey])) {
                $bind[$newKey] = $bind[$originalKey];
            }
            if (isset($bindTypes[$originalKey])) {
                $bindTypes[$newKey] = $bindTypes[$originalKey];
            }
            
            return $newPlaceholder;
        }, $sql);
        
        return [$newSql, $bind, $bindTypes];
    }
}
