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

use Phalcon\Filter\Validation\Validator\Between;
use Phalcon\Filter\Validation\Validator\Date;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\StringLength\Min;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Zemit\Db\Column;
use Zemit\Filter\Validation\Validator\Color;
use Zemit\Filter\Validation\Validator\Json;
use Zemit\Filter\Validation;

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
        
        return $validator;
    }
    
    /**
     * Add basic validations for an unsigned field
     * - Must be numeric
     * - Must be an unsigned integer
     */
    public function addUnsignedIntValidation(Validation $validator, string $field = 'id', bool $allowEmpty = true): Validation
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
            'minimum' => Column::MIN_UNSIGNED_INT,
            'maximum' => Column::MAX_UNSIGNED_INT,
            'message' => $this->_('not-an-unsigned-integer'),
            'allowEmpty' => $allowEmpty,
        ]));
        
        return $validator;
    }
    
    /**
     * Add basic validations for an unsigned field
     * - Must be numeric
     * - Must be an unsigned integer
     */
    public function addUnsignedBigIntValidation(Validation $validator, string $field = 'id', bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        // Must be numeric
        $validator->add($field, new Numericality([
            'message' => $this->_('not-numeric'),
            'allowEmpty' => true,
        ]));
        
        // Must be an unsigned integer
        $validator->add($field, new Between([
            'minimum' => Column::MIN_UNSIGNED_BIGINT,
            'maximum' => Column::MAX_UNSIGNED_BIGINT,
            'message' => $this->_('not-an-unsigned-big-integer'),
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    public function addNumberValidation(Validation $validator, string $field, int $min, int $max, bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        // Must be numeric
        $validator->add($field, new Numericality([
            'message' => $this->_('not-numeric'),
            'allowEmpty' => true,
        ]));
        
        // Must be an unsigned integer
        $validator->add($field, new Between([
            'minimum' => $min,
            'maximum' => $max,
            'message' => $this->_('not-between'),
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    public function addStringLengthValidation(Validation $validator, string $field, int $minChar = 0, int $maxChar = 255, bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Min([
            'min' => $minChar,
            'message' => $this->_('min-length'),
            'allowEmpty' => true,
        ]));
        
        $validator->add($field, new Max([
            'max' => $maxChar,
            'message' => $this->_('max-length'),
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    public function addInclusionInValidation(Validation $validator, string $field, array $domainList = [], bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new InclusionIn([
            'message' => $this->_('not-valid'),
            'domain' => $domainList,
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    /**
     * Add boolean validation
     * - Must be 0, 1, true or false
     */
    public function addBooleanValidation(Validation $validator, string $field, bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new InclusionIn([
            'message' => $this->_('not-boolean'),
            'domain' => [1, 0, true, false],
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    /**
     * Add domain inclusion validation
     * - Must be valid value from the domain list
     */
    public function addInclusionValidation(Validation $validator, string $field, array $domain = [], bool $allowEmpty = true, bool $strict = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new InclusionIn([
            'message' => $this->_('not-valid'),
            'domain' => $domain,
            'strict' => $strict,
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    /**
     * Add presence validation
     * - Must be present
     */
    public function addPresenceValidation(Validation $validator, string $field, bool $allowEmpty = true): Validation
    {
        $validator->add($field, new PresenceOf([
            'message' => $this->_('required'),
            'allowEmpty' => $allowEmpty,
        ]));
        
        return $validator;
    }
    
    /**
     * Add uniqueness validation
     * - Must be present (if allowEmpty is false)
     * - Must be unique
     */
    public function addUniquenessValidation(Validation $validator, string|array $field, bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Uniqueness([
            'message' => $this->_('not-unique'),
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    public function addDateValidation(Validation $validator, string $field, bool $allowEmpty = true, string $format = Column::DATE_FORMAT)
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Date([
            'format' => $format,
            'message' => $this->_('invalid-date-format'),
            'allowEmpty' => true,
        ]));
    }
    
    public function addDateTimeValidation(Validation $validator, string $field, bool $allowEmpty = true, string $format = Column::DATETIME_FORMAT)
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Date([
            'format' => $format,
            'message' => $this->_('invalid-date-format'),
            'allowEmpty' => true,
        ]));
    }
    
    public function addJsonValidation(Validation $validator, string $field, bool $allowEmpty = true, int $depth = 512, int $flags = 0)
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Json([
            'message' => $this->_('not-valid-json'),
            'depth' => $depth,
            'flags' => $flags,
            'allowEmpty' => true,
        ]));
    }
    
    public function addColorValidation(Validation $validator, string $field, bool $allowEmpty = true): Validation
    {
        if (!$allowEmpty) {
            $validator->add($field, new PresenceOf([
                'message' => $this->_('required'),
                'allowEmpty' => false,
            ]));
        }
        
        $validator->add($field, new Color([
            'message' => $this->_('not-hex-color'),
            'allowEmpty' => true,
        ]));
        
        return $validator;
    }
    
    /**
     * Add basic validation for the id field
     * - Must be an unsigned number
     * - Must be unique
     */
    public function addIdValidation(Validation $validator, string $field = 'id'): Validation
    {
        if (property_exists($this, $field)) {
            
            $this->addUnsignedIntValidation($validator, $field);
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the position field
     * - Must be numeric
     * - Must be an unsigned integer
     */
    public function addPositionValidation(Validation $validator, string $field = 'position', bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $field)) {
            
            if (!$allowEmpty) {
                $validator->add($field, new PresenceOf([
                    'message' => $this->_('required'),
                    'allowEmpty' => false,
                ]));
            }
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => true,
            ]));
            
            // Must be an unsigned integer
            $validator->add($field, new Between([
                'minimum' => Column::MIN_UNSIGNED_INT,
                'maximum' => Column::MAX_UNSIGNED_INT,
                'message' => $this->_('not-an-unsigned-integer'),
                'allowEmpty' => true,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the position field
     * - Must be YES or NO
     * - Must be numeric
     */
    public function addSoftDeleteValidation(Validation $validator, string $field = 'deleted', bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $field)) {
            
            if (!$allowEmpty) {
                $validator->add($field, new PresenceOf([
                    'message' => $this->_('required'),
                    'allowEmpty' => false,
                ]));
            }
            
            // Must be YES or NO
            $validator->add($field, new InclusionIn([
                'message' => $this->_('not-valid'),
                'domain' => [Column::YES, Column::NO],
                'strict' => true,
            ]));
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => true,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the $field
     * - Must be unique
     * - Field is required
     */
    public function addUuidValidation(Validation $validator, string $field = 'uuid', bool $allowEmpty = false): Validation
    {
        if (property_exists($this, $field) && $this->getModelsMetaData()->hasAttribute($this, $field)) {
            
            // If field is required
            if (!$allowEmpty) {
                $validator->add($field, new PresenceOf([
                    'message' => $this->_('required'),
                    'allowEmpty' => false,
                ]));
            }
            
            // Must be unique
            $validator->add($field, new Uniqueness([
                'message' => $this->_('not-unique'),
                'allowEmpty' => true,
            ]));
        }
        
        return $validator;
    }
    
    /**
     * Add basic validations for the $userIdField and $dateField field
     * - $userIdField: Must be numeric
     * - $userIdField: Must be an unsigned integer
     * - $dateField: Must be a valid date
     */
    public function addCrudValidation(Validation $validator, string $userIdField, string $dateField, bool $allowEmpty = true): Validation
    {
        if (property_exists($this, $userIdField)) {
            
            if (!$allowEmpty) {
                $validator->add($userIdField, new PresenceOf([
                    'message' => $this->_('required'),
                    'allowEmpty' => false,
                ]));
            }
            
            // Must be numeric
            $validator->add($userIdField, new Numericality([
                'message' => $this->_('not-numeric'),
                'allowEmpty' => true,
            ]));
            
            // Must be an unsigned integer
            $validator->add($userIdField, new Between([
                'minimum' => Column::MIN_UNSIGNED_INT,
                'maximum' => Column::MAX_UNSIGNED_INT,
                'message' => $this->_('not-an-unsigned-integer'),
                'allowEmpty' => true,
            ]));
        }
        
        if (property_exists($this, $dateField)) {
            
            // if the $userIdField is filled
            if (!empty($this->readAttribute($userIdField))) {
                
                $validator->add($dateField, new PresenceOf([
                    'message' => $this->_('required'),
                    'allowEmpty' => false,
                ]));
                
                // Must be a valid date format
                $validator->add($dateField, new Date([
                    'format' => Column::DATETIME_FORMAT,
                    'message' => $this->_('invalid-date-format'),
                    'allowEmpty' => true,
                ]));
            }
        }
        
        return $validator;
    }
    
    /**
     * Add crud validation to the user id and date field
     */
    public function addCreatedValidation(Validation $validator, string $createdByField = 'createdBy', string $createdAtField = 'createdAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $createdByField, $createdAtField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     */
    public function addUpdatedValidation(Validation $validator, string $updatedByField = 'updatedBy', string $updatedAtField = 'updatedAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $updatedByField, $updatedAtField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     */
    public function addDeletedValidation(Validation $validator, string $deletedField = 'deletedBy', string $dateField = 'deletedAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $deletedField, $dateField, $allowEmpty);
    }
    
    /**
     * Add crud validation to the user id and date field
     */
    public function addRestoredValidation(Validation $validator, string $restoredByField = 'restoredBy', string $restoredAtField = 'restoredAt', bool $allowEmpty = true): Validation
    {
        return $this->addCrudValidation($validator, $restoredByField, $restoredAtField, $allowEmpty);
    }
}
