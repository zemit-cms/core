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
use Zemit\Models\AbstractModel;
use Zemit\Models\Audit;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\AuditDetailAbstractInterface;

/**
 * Class AuditDetailAbstract
 *
 * This class defines a AuditDetail abstract model that extends the AbstractModel class and implements the AuditDetailAbstractInterface.
 * It provides properties and methods for managing AuditDetail data.
 * 
 * @property Audit $auditentity
 * @property Audit $AuditEntity
 * @method Audit getAuditEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 *
 * @property User $createdasentity
 * @property User $CreatedAsEntity
 * @method User getCreatedAsEntity(?array $params = null)
 *
 * @property User $updatedbyentity
 * @property User $UpdatedByEntity
 * @method User getUpdatedByEntity(?array $params = null)
 *
 * @property User $updatedasentity
 * @property User $UpdatedAsEntity
 * @method User getUpdatedAsEntity(?array $params = null)
 *
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 *
 * @property User $deletedasentity
 * @property User $DeletedAsEntity
 * @method User getDeletedAsEntity(?array $params = null)
 *
 * @property User $restoredbyentity
 * @property User $RestoredByEntity
 * @method User getRestoredByEntity(?array $params = null)
 *
 * @property User $restoredasentity
 * @property User $RestoredAsEntity
 * @method User getRestoredAsEntity(?array $params = null)
 */
abstract class AuditDetailAbstract extends AbstractModel implements AuditDetailAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: audit_id
     * Attributes: NotNull | Numeric | Unsigned | Type(14)
     * @var mixed
     */
    public mixed $auditId = null;
        
    /**
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public mixed $model = null;
        
    /**
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $table = null;
        
    /**
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $primary = null;
        
    /**
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @var mixed
     */
    public mixed $event = 'other';
        
    /**
     * Column: column
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $column = null;
        
    /**
     * Column: map
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $map = null;
        
    /**
     * Column: before
     * Attributes: Type(23)
     * @var mixed
     */
    public mixed $before = null;
        
    /**
     * Column: after
     * Attributes: Type(23)
     * @var mixed
     */
    public mixed $after = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public mixed $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public mixed $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $deletedAt = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedBy = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedAs = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $restoredBy = null;
        
    /**
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $restoredAs = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field auditId
     * Column: audit_id
     * Attributes: NotNull | Numeric | Unsigned | Type(14)
     * @return mixed
     */
    public function getAuditId(): mixed
    {
        return $this->auditId;
    }
    
    /**
     * Sets the value of field auditId
     * Column: audit_id 
     * Attributes: NotNull | Numeric | Unsigned | Type(14)
     * @param mixed $auditId
     * @return void
     */
    public function setAuditId(mixed $auditId): void
    {
        $this->auditId = $auditId;
    }
    
    /**
     * Returns the value of field model
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getModel(): mixed
    {
        return $this->model;
    }
    
    /**
     * Sets the value of field model
     * Column: model 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $model
     * @return void
     */
    public function setModel(mixed $model): void
    {
        $this->model = $model;
    }
    
    /**
     * Returns the value of field table
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getTable(): mixed
    {
        return $this->table;
    }
    
    /**
     * Sets the value of field table
     * Column: table 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $table
     * @return void
     */
    public function setTable(mixed $table): void
    {
        $this->table = $table;
    }
    
    /**
     * Returns the value of field primary
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPrimary(): mixed
    {
        return $this->primary;
    }
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $primary
     * @return void
     */
    public function setPrimary(mixed $primary): void
    {
        $this->primary = $primary;
    }
    
    /**
     * Returns the value of field event
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @return mixed
     */
    public function getEvent(): mixed
    {
        return $this->event;
    }
    
    /**
     * Sets the value of field event
     * Column: event 
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @param mixed $event
     * @return void
     */
    public function setEvent(mixed $event): void
    {
        $this->event = $event;
    }
    
    /**
     * Returns the value of field column
     * Column: column
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getColumn(): mixed
    {
        return $this->column;
    }
    
    /**
     * Sets the value of field column
     * Column: column 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $column
     * @return void
     */
    public function setColumn(mixed $column): void
    {
        $this->column = $column;
    }
    
    /**
     * Returns the value of field map
     * Column: map
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getMap(): mixed
    {
        return $this->map;
    }
    
    /**
     * Sets the value of field map
     * Column: map 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $map
     * @return void
     */
    public function setMap(mixed $map): void
    {
        $this->map = $map;
    }
    
    /**
     * Returns the value of field before
     * Column: before
     * Attributes: Type(23)
     * @return mixed
     */
    public function getBefore(): mixed
    {
        return $this->before;
    }
    
    /**
     * Sets the value of field before
     * Column: before 
     * Attributes: Type(23)
     * @param mixed $before
     * @return void
     */
    public function setBefore(mixed $before): void
    {
        $this->before = $before;
    }
    
    /**
     * Returns the value of field after
     * Column: after
     * Attributes: Type(23)
     * @return mixed
     */
    public function getAfter(): mixed
    {
        return $this->after;
    }
    
    /**
     * Sets the value of field after
     * Column: after 
     * Attributes: Type(23)
     * @param mixed $after
     * @return void
     */
    public function setAfter(mixed $after): void
    {
        $this->after = $after;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
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
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs(mixed $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt(mixed $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs(mixed $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt(mixed $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy(mixed $restoredBy): void
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs(): mixed
    {
        return $this->restoredAs;
    }
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs(mixed $restoredAs): void
    {
        $this->restoredAs = $restoredAs;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('auditId', Audit::class, 'id', ['alias' => 'AuditEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

        $this->belongsTo('restoredBy', User::class, 'id', ['alias' => 'RestoredByEntity']);

        $this->belongsTo('restoredAs', User::class, 'id', ['alias' => 'RestoredAsEntity']);
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
        $this->addUnsignedIntValidation($validator, 'auditId', false);
        $this->addStringLengthValidation($validator, 'model', 0, 255, false);
        $this->addStringLengthValidation($validator, 'table', 0, 60, false);
        $this->addUnsignedIntValidation($validator, 'primary', false);
        $this->addInclusionInValidation($validator, 'event', ['create','update','delete','restore','other'], false);
        $this->addStringLengthValidation($validator, 'column', 0, 60, false);
        $this->addStringLengthValidation($validator, 'map', 0, 60, false);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
        $this->addDateTimeValidation($validator, 'restoredAt', true);
        $this->addUnsignedIntValidation($validator, 'restoredBy', true);
        $this->addUnsignedIntValidation($validator, 'restoredAs', true);
        
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
            'audit_id' => 'auditId',
            'model' => 'model',
            'table' => 'table',
            'primary' => 'primary',
            'event' => 'event',
            'column' => 'column',
            'map' => 'map',
            'before' => 'before',
            'after' => 'after',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_by' => 'deletedBy',
            'deleted_as' => 'deletedAs',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
            'restored_as' => 'restoredAs',
        ];
    }
}
