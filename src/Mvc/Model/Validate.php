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

use Phalcon\Security;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\StringLength\Min;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Validation;

// Boolean
const YES = 1;
const NO = 0;

// TinyInt
const MIN_UNSIGNED_TINYINT = 0;
const MAX_UNSIGNED_TINYINT = 255;
const MIN_SIGNED_TINYINT = -128;
const MAX_SIGNED_TINYINT = 127;

// SmallInt
const MIN_UNSIGNED_SMALLINT = 0;
const MAX_UNSIGNED_SMALLINT = 65535;
const MIN_SIGNED_SMALLINT = -32768;
const MAX_SIGNED_SMALLINT = 32767;

// MediumInt
const MIN_UNSIGNED_MEDIUMINT = 0;
const MAX_UNSIGNED_MEDIUMINT = 16777215;
const MIN_SIGNED_MEDIUMINT = -8388608;
const MAX_SIGNED_MEDIUMINT = 8388607;

// Int
const MIN_UNSIGNED_INT = 0;
const MAX_UNSIGNED_INT = 4294967295;
const MIN_SIGNED_INT = -2147483648;
const MAX_SIGNED_INT = 2147483647;

// BigInt
const MIN_UNSIGNED_BIGINT = 0;
const MAX_UNSIGNED_BIGINT = 18446744073709551615;
const MIN_SIGNED_BIGINT = -9223372036854775808;
const MAX_SIGNED_BIGINT = 9223372036854775807;

// Float
const MIN_SIGNED_FLOAT = -3.402823466E+38;
const MAX_SIGNED_FLOAT = -1.175494351E-38;
const MIN_UNSIGNED_FLOAT = 1.175494351E-38;
const MAX_UNSIGNED_FLOAT = 3.402823466E+38;

// Double
const MIN_SIGNED_DOUBLE = -1.7976931348623157E+308;
const MAX_SIGNED_DOUBLE = -2.2250738585072014E-308;
const MIN_UNSIGNED_DOUBLE = 2.2250738585072014E-308;
const MAX_UNSIGNED_DOUBLE = 1.7976931348623157E+308;

// Decimal
const MAX_DECIMAL_DIGIT = 65;

// DateTime
const DATETIME_FORMAT = 'Y-m-d H:i:s';
const DATETIME_MIN = '1000-01-01 00:00:00';
const DATETIME_MAX = '9999-12-31 23:59:59';

// Date
const DATE_FORMAT = 'Y-m-d';
const DATE_MIN = '1000-01-01';
const DATE_MAX = '9999-12-31';

// Timestamp
const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';
const TIMESTAMP_MIN = '1970-01-01 00:00:01';
const TIMESTAMP_MAX = '2038-01-19 03:14:07';

// Year
const YEAR_MIN = 1901;
const YEAR_MAX = 2155;

// Char
const CHAR_MIN_LENGTH = 0;
const CHAR_MAX_LENGTH = 255;

// VarChar
const VARCHAR_MIN_LENGTH = 0;
const VARCHAR_MAX_LENGTH = 65535;

// Binary
const BINARY_MIN_BYTES = 0;
const BINARY_MAX_BYTES = 255;

// VarBinary
const VARBINARY_MIN_BYTES = 0;
const VARBINARY_MAX_BYTES = 65535;

// Blob
const TINYBLOB_MIN_LENGTH = 0;
const TINYBLOB_MAX_LENGTH = 255;
const BLOB_MIN_LENGTH = 0;
const BLOB_MAX_LENGTH = 65535;
const MEDIUMBLOB_MIN_LENGTH = 0;
const MEDIUMBLOB_MAX_LENGTH = 16777215;
const LONGBLOB_MIN_LENGTH = 0;
const LONGBLOB_MAX_LENGTH = 4294967295;

// Text
const TINYTEXT_MIN_LENGTH = 0;
const TINYTEXT_MAX_LENGTH = 255;
const TEXT_MIN_LENGTH = 0;
const TEXT_MAX_LENGTH = 65535;
const MEDIUMTEXT_MIN_LENGTH = 0;
const MEDIUMTEXT_MAX_LENGTH = 16777215;
const LONGTEXT_MIN_LENGTH = 0;
const LONGTEXT_MAX_LENGTH = 4294967295;

trait Validate
{
    /**
     * Add default basic validations
     * - Position
     * - Soft delete
     * - Create
     * - Update
     * - Delete
     * - Restore
     * - Uuid
     * - Uid
     * - Guid
     *
     * @param Validation|null $validator
     * @return Validation
     */
    public function genericValidation(?Validation $validator = null)
    {
        $validator ??= new Validation();
        
        $this->addPositionValidation($validator);
        $this->addSoftDeleteValidation($validator);
        $this->addCreatedValidation($validator);
        $this->addUpdatedValidation($validator);
        $this->addDeletedValidation($validator);
        $this->addRestoredValidation($validator);
        $this->addUuidValidation($validator, 'uid');
        $this->addUuidValidation($validator, 'uuid');
        $this->addUuidValidation($validator, 'guid');
        
        return $validator;
    }
    
    /**
     * Add basic validations for an unsigned field to the validator
     * - Must be numeric
     * - Must be an unsigned integer
     *
     * @param Validation $validator
     * @param string $field
     * @param bool $allowEmpty
     * @return Validation
     */
    public function addUnsignedIntValidation(Validation $validator, string $field = 'id', bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $field)) {
            
            if (!$allowEmpty) {
                $validator->add($field, new PresenceOf([
                    'message' => $this->_('required'),
                ]));
            }
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($field, new Between([
                'minimum' => 0,
                'maximum' => MAX_UNSIGNED_INT,
                'message' => $this->_('not-an-unsigned-integer'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for an unsigned field to the validator
     * - Must be numeric
     * - Must be an unsigned integer
     *
     * @param Validation $validator
     * @param string $field
     * @param bool $allowEmpty
     * @return Validation
     */
    public function addUnsignedBigIntValidation(Validation $validator, string $field = 'id', bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $field)) {
            
            if (!$allowEmpty) {
                $validator->add($field, new PresenceOf([
                    'message' => $this->_('required'),
                ]));
            }
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($field, new Between([
                'minimum' => 0,
                'maximum' => MAX_UNSIGNED_BIGINT,
                'message' => $this->_('not-an-unsigned-big-integer'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        return $validator;
    }
    
    public function addNumberValidation(Validation $validator, string $field, int $min, int $max, bool $allowEmpty = true)
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
            ]));
        }
        
        // Must be numeric
        $validator->add($field, new Numericality([
            'message' => $this->_('not-numeric'),
            'allowEmpty' => $allowEmpty,
        ]));
        
        // Must be an unsigned integer
        $validator->add($field, new Between([
            'minimum' => $min,
            'maximum' => $max,
            'message' => $this->_('not-between'),
            'allowEmpty' => $allowEmpty,
        ]));
    }
    
    public function addStringLengthValidation(Validation $validator, string $field, int $minChar = 0, int $maxChar = 255, bool $allowEmpty = true)
    {
        
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
            ]));
        }
        
        $validator->add($field, new Min([
            'min' => $minChar,
            'message' => $this->_('min-length'),
        ]));
        
        $validator->add($field, new Max([
            'max' => $maxChar,
            'message' => $this->_('max-length'),
        ]));
        
        return $validator;
    }
    
    public function addInclusionInValidation(Validation $validator, string $field, array $domainList = [], bool $allowEmpty = true)
    {
        
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
            ]));
        }
        
        $validator->add($field, new InclusionIn([
            'message' => $this->_('not-valid'),
            'domain' => $domainList,
        ]));
    }
    
    public function addBooleanValidation(Validation $validator, string $field, bool $allowEmpty = true)
    {
        
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
            ]));
        }
        
        $validator->add($field, new InclusionIn([
            'message' => $this->_('not-boolean'),
            'domain' => [YES, NO, 1, 0, true, false],
        ]));
    }
    
    /**
     * Add basic validations for the position field to the validator
     * - Must be numeric
     * - Must be an unsigned integer
     *
     * @param Validation $validator
     * @param string $field
     * @param bool $allowEmpty
     * @return Validation
     */
    public function addPositionValidation(Validation $validator, string $field = 'position', bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $field)) {
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($field, new Between([
                'minimum' => 0,
                'maximum' => MAX_UNSIGNED_INT,
                'message' => $this->_('not-an-unsigned-integer'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the position field to the validator
     * - Must be 0 or 1
     * - Must be numeric
     *
     * @param Validation $validator
     * @param string $field
     * @param bool $allowEmpty
     * @return void
     */
    public function addSoftDeleteValidation(Validation $validator, string $field = 'deleted', bool $allowEmpty = true)
    {
        if (property_exists($this, $field)) {
            
            // Must be 0 or 1
            $validator->add($field, new Between([
                'minimum' => 0,
                'maximum' => 1,
                'message' => $this->_('not-0-or-1'),
            ]));
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
    }
    
    /**
     * Disable audit & audit details blamable behavior
     * @return void
     */
    public function addBlameableBehavior(): void
    {
        // disabled
    }
    
    /**
     * Add basic validations for the $field to the validator
     * - Must be unique
     * - Field is required
     *
     * @param Validation $validator
     * @param string $field uuid field to validate
     * @param bool $required set to true to add the PresenceOf validation
     * @return Validation
     */
    public function addUuidValidation(Validation $validator, string $field = 'uuid', bool $required = true)
    {
        if (property_exists($this, $field) && $this->getModelsMetaData()->hasAttribute($this, $field)) {
            
            // If field is required
            if ($required) {
                $validator->add($field, new PresenceOf(['message' => $this->_('required')]));
            }
            
            // Must be unique
            $validator->add($field, new Uniqueness(['message' => $this->_('not-unique')]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the $userIdField and $dateField field to the validator
     * - $userIdField: Must be numeric
     * - $userIdField: Must be an unsigned integer
     * - $dateField: Must be a valid date
     *
     * @param Validation $validator
     * @param string $userIdField user id field to validate
     * @param string $dateField date field to validate
     * @param bool $allowEmpty set true to allow empty values in user and date field
     * @return Validation
     */
    public function addCrudValidation(Validation $validator, string $userIdField, string $dateField, bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $userIdField)) {
            
            // Must be numeric
            $validator->add($userIdField, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($userIdField, new Between([
                'minimum' => 0,
                'maximum' => MAX_UNSIGNED_INT,
                'message' => $this->_('not-an-unsigned-integer'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        if (property_exists($this, $dateField)) {
            
            // Must be a valid date format
            $validator->add($dateField, new Date([
                'format' => DATETIME_FORMAT,
                'message' => $this->_('invalid-date-format'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add crud validation to the user id and date field
     *
     * @param Validation $validator
     * @param string $createdByField user id field to validate
     * @param string $createdAtField date field to validate
     * @param bool $allowEmpty set true to allow empty values in user and date field
     * @return Validation
     */
    public function addCreatedValidation(Validation $validator, string $createdByField = 'createdBy', string $createdAtField = 'createdAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $createdByField, $createdAtField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     *
     * @param Validation $validator
     * @param string $updatedByField user id field to validate
     * @param string $updatedAtField date field to validate
     * @param bool $allowEmpty set true to allow empty values in user and date field
     * @return Validation
     */
    public function addUpdatedValidation(Validation $validator, string $updatedByField = 'updatedBy', string $updatedAtField = 'updatedAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $updatedByField, $updatedAtField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     *
     * @param Validation $validator
     * @param string $deletedField user id field to validate
     * @param string $dateField date field to validate
     * @param bool $allowEmpty set true to allow empty values in user and date field
     * @return Validation
     */
    public function addDeletedValidation(Validation $validator, string $deletedField = 'deletedBy', string $dateField = 'deletedAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $deletedField, $dateField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     *
     * @param Validation $validator
     * @param string $restoredByField user id field to validate
     * @param string $restoredAtField date field to validate
     * @param bool $allowEmpty set true to allow empty values in user and date field
     * @return Validation
     */
    public function addRestoredValidation(Validation $validator, string $restoredByField = 'restoredBy', string $restoredAtField = 'restoredAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $restoredByField, $restoredAtField, $allowEmpty);
    }
}
