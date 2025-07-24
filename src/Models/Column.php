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

use Zemit\Models\Abstracts\ColumnAbstract;
use Zemit\Models\Enums\ColumnType;
use Zemit\Models\Interfaces\ColumnInterface;
use Phalcon\Db\Column as DbColumn;

/**
 * Class Column
 *
 * This class represents a Column object.
 * It extends the ColumnAbstract class and implements the ColumnInterface.
 */
class Column extends ColumnAbstract implements ColumnInterface
{
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
    
    public function getColumnDefinitions(): array {
        return self::getColumnDefinitionsByType(ColumnType::from($this->getType()));
    }
    
    public static function getColumnDefinitionsByType(ColumnType $type): array {
        return match ($type) {
            // Map cases to Phalcon\Db\Column constants with default sizes
            ColumnType::LINK_TO_ANOTHER_RECORD,
            ColumnType::USER,
            ColumnType::CREATED_BY,
            ColumnType::LAST_MODIFIED_BY,
            ColumnType::NUMBER,
            ColumnType::RATING,
            ColumnType::COUNT => ['type' => DbColumn::TYPE_INTEGER, 'size' => 11],
            
            ColumnType::SINGLE_LINE_TEXT,
            ColumnType::EMAIL,
            ColumnType::URL,
            ColumnType::PHONE_NUMBER,
            ColumnType::BARCODE,
            ColumnType::BUTTON => ['type' => DbColumn::TYPE_VARCHAR, 'size' => 255],
            
            ColumnType::LONG_TEXT => ['type' => DbColumn::TYPE_TEXT, 'size' => null], // TEXT type doesn't require size
            ColumnType::ATTACHMENT => ['type' => DbColumn::TYPE_BLOB, 'size' => null], // BLOB type doesn't require size
            ColumnType::CHECKBOX => ['type' => DbColumn::TYPE_BOOLEAN, 'size' => 1],
            
            ColumnType::MULTIPLE_SELECT,
            ColumnType::SINGLE_SELECT => ['type' => DbColumn::TYPE_ENUM, 'size' => null], // ENUM size varies depending on values
            
            ColumnType::DATE,
            ColumnType::CREATED_TIME,
            ColumnType::LAST_MODIFIED_TIME => ['type' => DbColumn::TYPE_DATETIME, 'size' => null], // DATETIME doesn't require size
            
            ColumnType::CURRENCY,
            ColumnType::PERCENT,
            ColumnType::FORMULA,
            ColumnType::ROLLUP => ['type' => DbColumn::TYPE_DECIMAL, 'size' => '10,2'], // Decimal with precision
            
            ColumnType::DURATION => ['type' => DbColumn::TYPE_TIME, 'size' => null], // TIME type doesn't require size
            ColumnType::AUTONUMBER => ['type' => DbColumn::TYPE_BIGINTEGER, 'size' => 20],
            
            default => ['type' => DbColumn::TYPE_VARCHAR, 'size' => 255], // Default MySQL type and size if unspecified
        };
    }
}
