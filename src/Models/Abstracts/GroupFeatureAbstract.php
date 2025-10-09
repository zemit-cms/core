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

namespace Zemit\Models\Abstracts;

use Phalcon\Db\RawValue;
use Zemit\Filter\Validation;
use \Zemit\Models\AbstractModel;
use Zemit\Models\Group;
use Zemit\Models\Feature;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\GroupFeatureAbstractInterface;

/**
 * Class GroupFeatureAbstract
 *
 * This class defines a GroupFeature abstract model that extends the AbstractModel class and implements the GroupFeatureAbstractInterface.
 * It provides properties and methods for managing GroupFeature data.
 * 
 * @property Group $groupentity
 * @property Group $GroupEntity
 * @method Group getGroupEntity(?array $params = null)
 *
 * @property Feature $featureentity
 * @property Feature $FeatureEntity
 * @method Feature getFeatureEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 */
abstract class GroupFeatureAbstract extends \Zemit\Models\AbstractModel implements GroupFeatureAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @var mixed
     */
    public mixed $uuid = null;
        
    /**
     * Column: group_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $groupId = null;
        
    /**
     * Column: feature_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $featureId = null;
        
    /**
     * Column: position
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @var mixed
     */
    public mixed $position = 0;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @var mixed
     */
    public mixed $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public mixed $createdAt = 'current_timestamp()';
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $createdBy = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed
    {
        return $this->uuid;
    }
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field groupId
     * Column: group_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getGroupId(): mixed
    {
        return $this->groupId;
    }
    
    /**
     * Sets the value of field groupId
     * Column: group_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $groupId
     * @return void
     */
    public function setGroupId(mixed $groupId): void
    {
        $this->groupId = $groupId;
    }
    
    /**
     * Returns the value of field featureId
     * Column: feature_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getFeatureId(): mixed
    {
        return $this->featureId;
    }
    
    /**
     * Sets the value of field featureId
     * Column: feature_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $featureId
     * @return void
     */
    public function setFeatureId(mixed $featureId): void
    {
        $this->featureId = $featureId;
    }
    
    /**
     * Returns the value of field position
     * Column: position
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @return mixed
     */
    public function getPosition(): mixed
    {
        return $this->position;
    }
    
    /**
     * Sets the value of field position
     * Column: position 
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @param mixed $position
     * @return void
     */
    public function setPosition(mixed $position): void
    {
        $this->position = $position;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);

        $this->belongsTo('featureId', Feature::class, 'id', ['alias' => 'FeatureEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @param Validation|null $validator
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addStringLengthValidation($validator, 'uuid', 0, 36, false);
        $this->addUnsignedIntValidation($validator, 'groupId', false);
        $this->addUnsignedIntValidation($validator, 'featureId', false);
        $this->addUnsignedIntValidation($validator, 'position', false);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        
        return $validator;
    }

        
    /**
     * Returns an array that maps the column names of the database
     * table to the corresponding property names of the model.
     * 
     * @returns array The array mapping the column names to the property names
     */
    public function columnMap(): array
    {
        return [
            'id' => 'id',
            'uuid' => 'uuid',
            'group_id' => 'groupId',
            'feature_id' => 'featureId',
            'position' => 'position',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
        ];
    }
}
