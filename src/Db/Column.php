<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db;

use Phalcon\Db\ColumnInterface;

class Column extends \Phalcon\Db\Column implements ColumnInterface
{
    // Boolean
    public const YES = 1;
    public const NO = 0;
    
    // TinyInt
    public const MIN_UNSIGNED_TINYINT = 0;
    public const MAX_UNSIGNED_TINYINT = 255;
    public const MIN_SIGNED_TINYINT = -128;
    public const MAX_SIGNED_TINYINT = 127;
    
    // SmallInt
    public const MIN_UNSIGNED_SMALLINT = 0;
    public const MAX_UNSIGNED_SMALLINT = 65535;
    public const MIN_SIGNED_SMALLINT = -32768;
    public const MAX_SIGNED_SMALLINT = 32767;
    
    // MediumInt
    public const MIN_UNSIGNED_MEDIUMINT = 0;
    public const MAX_UNSIGNED_MEDIUMINT = 16777215;
    public const MIN_SIGNED_MEDIUMINT = -8388608;
    public const MAX_SIGNED_MEDIUMINT = 8388607;
    
    // Int
    public const MIN_UNSIGNED_INT = 0;
    public const MAX_UNSIGNED_INT = 4294967295;
    public const MIN_SIGNED_INT = -2147483648;
    public const MAX_SIGNED_INT = 2147483647;
    
    // BigInt
    public const MIN_UNSIGNED_BIGINT = 0;
    public const MAX_UNSIGNED_BIGINT = 18446744073709551615;
    public const MIN_SIGNED_BIGINT = -9223372036854775808;
    public const MAX_SIGNED_BIGINT = 9223372036854775807;
    
    // Float
    public const MIN_SIGNED_FLOAT = -3.402823466E+38;
    public const MAX_SIGNED_FLOAT = -1.175494351E-38;
    public const MIN_UNSIGNED_FLOAT = 1.175494351E-38;
    public const MAX_UNSIGNED_FLOAT = 3.402823466E+38;
    
    // Double
    public const MIN_SIGNED_DOUBLE = -1.7976931348623157E+308;
    public const MAX_SIGNED_DOUBLE = -2.2250738585072014E-308;
    public const MIN_UNSIGNED_DOUBLE = 2.2250738585072014E-308;
    public const MAX_UNSIGNED_DOUBLE = 1.7976931348623157E+308;
    
    // Decimal
    public const MAX_DECIMAL_DIGIT = 65;
    
    // DateTime
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const DATETIME_MIN = '1000-01-01 00:00:00';
    public const DATETIME_MAX = '9999-12-31 23:59:59';
    
    // Date
    public const DATE_FORMAT = 'Y-m-d';
    public const DATE_MIN = '1000-01-01';
    public const DATE_MAX = '9999-12-31';
    
    // Timestamp
    public const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';
    public const TIMESTAMP_MIN = '1970-01-01 00:00:01';
    public const TIMESTAMP_MAX = '2038-01-19 03:14:07';
    
    // Year
    public const YEAR_MIN = 1901;
    public const YEAR_MAX = 2155;
    
    // Char
    public const CHAR_MIN_LENGTH = 0;
    public const CHAR_MAX_LENGTH = 255;
    
    // VarChar
    public const VARCHAR_MIN_LENGTH = 0;
    public const VARCHAR_MAX_LENGTH = 65535;
    
    // Binary
    public const BINARY_MIN_BYTES = 0;
    public const BINARY_MAX_BYTES = 255;
    
    // VarBinary
    public const VARBINARY_MIN_BYTES = 0;
    public const VARBINARY_MAX_BYTES = 65535;
    
    // Blob
    public const TINYBLOB_MIN_LENGTH = 0;
    public const TINYBLOB_MAX_LENGTH = 255;
    public const BLOB_MIN_LENGTH = 0;
    public const BLOB_MAX_LENGTH = 65535;
    public const MEDIUMBLOB_MIN_LENGTH = 0;
    public const MEDIUMBLOB_MAX_LENGTH = 16777215;
    public const LONGBLOB_MIN_LENGTH = 0;
    public const LONGBLOB_MAX_LENGTH = 4294967295;
    
    // Text
    public const TINYTEXT_MIN_LENGTH = 0;
    public const TINYTEXT_MAX_LENGTH = 255;
    public const TEXT_MIN_LENGTH = 0;
    public const TEXT_MAX_LENGTH = 65535;
    public const MEDIUMTEXT_MIN_LENGTH = 0;
    public const MEDIUMTEXT_MAX_LENGTH = 16777215;
    public const LONGTEXT_MIN_LENGTH = 0;
    public const LONGTEXT_MAX_LENGTH = 4294967295;
}
