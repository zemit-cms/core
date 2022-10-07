<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Db\Column;
use Phalcon\Support\HelperFactory;
use Zemit\Modules\Cli\Task;

/**
 * Class ScaffoldTask
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class ScaffoldTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli scaffold <action> [<params> ...]

Options:
  task: scaffold
  action: main


DOC;
    
    public $modelsPath = 'ts/Models/';
    public $abstractPath = './Base/';
    
    public function allModelsAction()
    {
        $ret = [];
        
        $tables = $this->db->listTables();
        foreach ($tables as $table) {
            
            $className = ucFirst((new HelperFactory)->camelize($table));
            $fileName = $className . '.ts';
            
            $abstractClassName = 'Abstract' . $className;
            $abstractFileName = $abstractClassName . '.ts';
            
            // Create Abstract
            $output = [];
            $output [] = 'import { AbstractModel } from \'../AbstractModel\';' . PHP_EOL;
            $output [] = 'export class ' . $abstractClassName . ' extends AbstractModel {';
            
            $columns = $this->db->describeColumns($table);
            foreach ($columns as $column) {
                
                switch ($column->getType()) {
                    case Column::TYPE_TIMESTAMP:
                    case Column::TYPE_MEDIUMINTEGER:
                    case Column::TYPE_SMALLINTEGER:
                    case Column::TYPE_TINYINTEGER:
                    case Column::TYPE_INTEGER:
                    case Column::TYPE_DECIMAL:
                    case Column::TYPE_DOUBLE:
                    case Column::TYPE_FLOAT:
                    case Column::TYPE_BIT:
                        $tsType = 'number';
                        break;
                    case Column::TYPE_BIGINTEGER:
                        $tsType = 'bigint';
                        break;
                    case Column::TYPE_ENUM:
//                        $tsType = 'enum';
//                        break;
                    case Column::TYPE_VARCHAR:
                    case Column::TYPE_CHAR:
                    case Column::TYPE_TEXT:
                    case Column::TYPE_TINYTEXT:
                    case Column::TYPE_MEDIUMTEXT:
                    case Column::TYPE_BLOB:
                    case Column::TYPE_TINYBLOB:
                    case Column::TYPE_LONGBLOB:
                    case Column::TYPE_DATETIME:
                    case Column::TYPE_DATE:
                    case Column::TYPE_TIME:
                        $tsType = 'string';
                        break;
                    case Column::TYPE_JSON:
                    case Column::TYPE_JSONB:
                        $tsType = 'object';
                        break;
                    case Column::TYPE_BOOLEAN:
                        $tsType = 'boolean';
                        break;
                    default:
                        $tsType = 'any';
                        break;
                }
                
                $columnDefault = $column->getDefault();
                switch (getType(strtolower($columnDefault))) {
                    // "boolean", "integer", "double", "string", "array", "object", "resource", "NULL", "unknown type", "resource (closed)"
                    case "boolean":
                    case "integer":
                    case "double":
                    case "null":
                        $default = $columnDefault;
                        break;
                    case "string":
                        if ($tsType === 'string') {
                            $default = !empty($columnDefault) ? '"' . addslashes($columnDefault) . '"' : null;
                        }
                        if ($tsType === 'number') {
                            $default = !empty($columnDefault) ? $columnDefault : null;
                        }
                        if ($tsType === 'array') {
                            $default = '[]';
                        }
                        if ($tsType === 'object') {
                            $default = '{}';
                        }
                        break;
                    case "array":
                        $default = '[]';
                        break;
                    case "object":
                        $default = '{}';
                        break;
                    default:
                        break;
                }
                
                $propertyName = lcfirst((new HelperFactory)->camelize($column->getName()));
                $output [] = '    public ' . $propertyName . ': ' . $tsType . (!empty($default) ? ' = ' . $default : null) . ';';
            }
            $output [] = '}';
            
            // Save Abstract Model File
            $this->saveFile(
                $this->modelsPath . $this->abstractPath . $abstractFileName,
                implode(PHP_EOL, $output)
            );
            
            $ret [] = 'Abstract Model ' . $abstractClassName . ' created';
            
            // Create Model
            $output = [];
            $output [] = 'import { ' . $abstractClassName . ' } from \'' . $this->abstractPath . $abstractClassName . '\';' . PHP_EOL;
            $output [] = 'export class ' . $className . ' extends ' . $abstractClassName . ' {';
            $output [] = '    ';
            $output [] = '}';
            
            // Save Model File
            $this->saveFile(
                $this->modelsPath . $fileName,
                implode(PHP_EOL, $output)
            );
            
            $ret [] = 'Model ' . $className . ' created';
        }
        
        dd($ret);
    }
    
    protected function saveFile($file, $text)
    {
        $file = fopen($file, 'w');
        fwrite($file, $text);
        fclose($file);
    }
}
