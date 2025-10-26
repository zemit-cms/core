<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Dialect;

use Phalcon\Db\Column;
use Phalcon\Db\ColumnInterface;
use Phalcon\Db\Dialect;

/**
 * Class MySQL
 * 
 * Mysql class extends \Phalcon\Db\Dialect\Mysql to provide additional functionalities for MySQL database dialect.
 * - Regexp: " %s REGEXP $s"
 * - Distance: " ST_Distance_Sphere(%s, %s) "
 * - point: " point(%s, %s) "
 */
class Mysql extends \Phalcon\Db\Dialect\Mysql
{
    public function __construct()
    {
        $this->registerRegexpFunction();
        $this->registerDistanceSphereFunction();
        $this->registerPointFunction();
    }
    
    /**
     * Register a custom REGEXP function for the database dialect.
     *
     * @return void
     */
    public function registerRegexpFunction(): void
    {
        $this->registerCustomFunction('regexp', function ($dialect, $expression) {
            $arguments = $expression['arguments'];
            return sprintf(
                " %s REGEXP %s",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
            );
        });
    }
    
    /**
     * Register a custom distance sphere function to be used in SQL queries.
     *
     * This method registers the "ST_Distance_Sphere" function, which calculates the spherical distance between two points.
     *
     * @return void
     */
    public function registerDistanceSphereFunction(): void
    {
        $this->registerCustomFunction('ST_Distance_Sphere', function (Dialect $dialect, array $expression) {
            $arguments = $expression['arguments'] ?? [];
            return sprintf(
                " ST_Distance_Sphere(%s, %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1]),
            );
        });
    }
    
    /**
     * Register a point function for SQL dialect.
     *
     * @return void
     */
    public function registerPointFunction(): void
    {
        $this->registerCustomFunction('point', function (Dialect $dialect, array $expression) {
            $arguments = $expression['arguments'] ?? [];
            return sprintf(
                " point(%s, %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1]),
            );
        });
    }
    
    /**
     * Get the SQL column definition for a given column.
     *
     * This is a temporary fix in regard to this github issue:
     * - https://github.com/phalcon/cphalcon/issues/16532
     * 
     * @param ColumnInterface $column The column to get the definition for.
     * @return string The SQL column definition.
     */
    #[\Override]
    public function getColumnDefinition(ColumnInterface $column): string
    {
        try {
            return parent::getColumnDefinition($column);
        }
        catch (\Phalcon\Db\Exception $e) {
            
            $columnSql = $this->checkColumnTypeSql($column);
            $columnType = $this->checkColumnType($column);
            
            switch ($columnType) {
                
                case Column::TYPE_BINARY:
                    if (empty($columnSql)) {
                        $columnSql .= 'BINARY';
                    }
                    if ($column->getSize() > 0) {
                        $columnSql .= $this->getColumnSize($column);
                    }
                    break;
                
                case Column::TYPE_VARBINARY:
                    if (empty($columnSql)) {
                        $columnSql .= 'VARBINARY';
                    }
                    if ($column->getSize() > 0) {
                        $columnSql .= $this->getColumnSize($column);
                    }
                    break;
            }
            
            return $columnSql;
        }
    }
}
