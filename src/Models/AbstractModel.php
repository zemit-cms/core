<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Phalcon\Mvc\Model\Relation;
use Phalcon\Filter\Validation\Validator\Between;
use Phalcon\Filter\Validation\Validator\Date;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Zemit\Locale;
use Zemit\Validation;

/**
 * Class Base
 *
 * @package Zemit\Models
 */
abstract class AbstractModel extends \Zemit\Mvc\Model
{
    const LANG_FR = 'fr';
    const LANG_EN = 'en';
    const LANG_SP = 'sp';
    const MAX_UNSIGNED_INT = 4294967295;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }
    
    /**
     * Set the default relationships
     *
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->addUserRelationship('userId', 'UserEntity');
        $this->addUserRelationship('createdBy', 'CreatedByEntity');
        $this->addUserRelationship('updatedBy', 'UpdatedByEntity');
        $this->addUserRelationship('deletedBy', 'DeletedByEntity');
        $this->addUserRelationship('restoredBy', 'RestoredByEntity');
    }
    
    /**
     * @param ?string $class
     * @param string $field
     * @param string $ref
     * @param string $alias
     * @param string $type
     * @param array $params
     * @return ?Relation
     */
    public function addUserRelationship(
        string $field = 'userId',
        string $alias = 'UserEntity',
        array $params = [],
        string $ref = 'id',
        string $type = 'belongsTo',
        ?string $class = null
    ): ?Relation {
        if (property_exists($this, $field)) {
            $class ??= $this->getIdentity()->getUserClass() ?: $this->getDI()->get('config')->getModelClass(User::class);
            return $this->$type($field, $class, $ref, ['alias' => $alias, 'params ' => $params]);
        }
        
        return null;
    }
    
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
                'message' => $this->_('not numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($field, new Between([
                'minimum' => 0,
                'maximum' => self::MAX_UNSIGNED_INT,
                'message' => $this->_('not an unsigned integer'),
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
                'message' => $this->_('not 0 or 1'),
            ]));
            
            // Must be numeric
            $validator->add($field, new Numericality([
                'message' => $this->_('not numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
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
            $validator->add($field, new Uniqueness(['message' => $this->_('not unique')]));
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
                'message' => $this->_('not numeric'),
                'allowEmpty' => $allowEmpty,
            ]));
            
            // Must be an unsigned integer
            $validator->add($userIdField, new Between([
                'minimum' => 0,
                'maximum' => self::MAX_UNSIGNED_INT,
                'message' => $this->_('not an unsigned integer'),
                'allowEmpty' => $allowEmpty,
            ]));
        }
        
        if (property_exists($this, $dateField)) {
            
            // Must be a valid date format
            $validator->add($dateField, new Date([
                'format' => self::DATETIME_FORMAT,
                'message' => $this->_('invalid date format'),
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
    
    /**
     * Returns the translation string of the given key
     *
     * @param array $placeholders
     * @param string $translateKey
     * @return string
     */
    public function _(string $translateKey, array $placeholders = []): string
    {
        /** @var \Phalcon\Translate\Adapter\AbstractAdapter $translate */
        $translate = $this->getDI()->get('translate');
        
        return $translate->_($translateKey, $placeholders);
    }
    
    /**
     * Magic caller to set or get localed named field automagically using the current locale
     * - Allow to call $this->getName{Fr|En|Sp|...}
     * - Allow to call $this->setName{Fr|En|Sp|...}
     *
     * @param string $method method name
     * @param array $arguments method arguments
     * @return mixed
     * @throws \Phalcon\Mvc\Model\Exception
     */
    public function __call(string $method, array $arguments)
    {
        /** @var Locale $locale */
        $locale = $this->getDI()->get('locale');
        
        $lang = $locale->getLocale() ?: 'en';
        
        if (mb_strrpos($method, ucfirst($lang)) !== mb_strlen($method) - mb_strlen($lang)) {
            $call = $method . ucfirst($lang);
            if (method_exists($this, $call)) {
                return $this->$call(...$arguments);
            }
        }
        
        return parent::__call($method, $arguments);
    }
    
    /**
     * Magic setter to set localed named field automatically using the current locale
     * - Allow to set $this->name{Fr|En|Sp|...} from missing name property
     *
     * @param string $property property name
     * @param mixed $value value to set
     * @return void
     */
    public function __set(string $property, $value)
    {
        /** @var Locale $locale */
        $locale = $this->getDI()->get('locale');
        
        $lang = $locale->getLocale() ?? '';
        
        if (mb_strrpos($property, ucfirst($lang)) !== mb_strlen($property) - 2) {
            $set = $property . ucfirst($lang);
            
            if (property_exists($this, $set)) {
                $this->writeAttribute($set, $value);
                
                return;
            }
        }
        
        parent::__set($property, $value);
    }
    
    /**
     * Magic getter to get localed named field automatically using the current locale
     * - Allow to get $this->name{Fr|En|Sp|...} from missing name property
     *
     * @param string $property property name
     * @return mixed|null
     */
    public function __get(string $property)
    {
        /** @var Locale $locale */
        $locale = $this->getDI()->get('locale');
        
        $lang = $locale->getLocale();
        
        if (mb_strrpos($property, ucfirst($lang)) !== mb_strlen($property) - 2) {
            $set = $property . ucfirst($lang);
            
            if (property_exists($this, $set)) {
                return $this->readAttribute($set);
            }
        }
        
        return parent::__get($property);
    }
    
    /**
     * @TODO Language support for isset as well
     */
//    public function __isset() {
//
//    }
}
