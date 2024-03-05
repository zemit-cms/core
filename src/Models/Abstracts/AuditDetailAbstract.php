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
use Zemit\Models\Abstracts\Interfaces\AuditDetailAbstractInterface;

/**
 * @property Audit $AuditEntity
 * @method Audit getAuditEntity(?array $params = null)
 */
class AuditDetailAbstract extends AbstractModel implements AuditDetailAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: audit_id
     * @var RawValue|int
     */
    public RawValue|int $auditId;
    
    /**
     * Column: model
     * @var RawValue|string
     */
    public RawValue|string $model;
    
    /**
     * Column: table
     * @var RawValue|string
     */
    public RawValue|string $table;
    
    /**
     * Column: primary
     * @var RawValue|int
     */
    public RawValue|int $primary;
    
    /**
     * Column: event
     * @var RawValue|string
     */
    public RawValue|string $event = 'other';
    
    /**
     * Column: column
     * @var RawValue|string
     */
    public RawValue|string $column;
    
    /**
     * Column: map
     * @var RawValue|string
     */
    public RawValue|string $map;
    
    /**
     * Column: before
     * @var RawValue|string|null
     */
    public RawValue|string|null $before = null;
    
    /**
     * Column: after
     * @var RawValue|string|null
     */
    public RawValue|string|null $after = null;
    
    /**
     * Column: deleted
     * @var RawValue|int
     */
    public RawValue|int $deleted = 0;
    
    /**
     * Column: created_at
     * @var RawValue|string
     */
    public RawValue|string $createdAt;
    
    /**
     * Column: created_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdBy = null;
    
    /**
     * Column: created_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdAs = null;
    
    /**
     * Column: updated_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $updatedAt = null;
    
    /**
     * Column: updated_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedBy = null;
    
    /**
     * Column: updated_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedAs = null;
    
    /**
     * Column: deleted_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $deletedAt = null;
    
    /**
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
    /**
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
    /**
     * Column: restored_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $restoredAt = null;
    
    /**
     * Column: restored_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $restoredBy = null;
    
    /**
     * Column: restored_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $restoredAs = null;
    /**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field auditId
     * Column: audit_id
     * @return RawValue|int
     */
    public function getAuditId(): RawValue|int
    {
        return $this->auditId;
    }
    
    /**
     * Sets the value of field auditId
     * Column: audit_id 
     * @param RawValue|int $auditId
     * @return void
     */
    public function setAuditId(RawValue|int $auditId): void
    {
        $this->auditId = $auditId;
    }
    
    /**
     * Returns the value of field model
     * Column: model
     * @return RawValue|string
     */
    public function getModel(): RawValue|string
    {
        return $this->model;
    }
    
    /**
     * Sets the value of field model
     * Column: model 
     * @param RawValue|string $model
     * @return void
     */
    public function setModel(RawValue|string $model): void
    {
        $this->model = $model;
    }
    
    /**
     * Returns the value of field table
     * Column: table
     * @return RawValue|string
     */
    public function getTable(): RawValue|string
    {
        return $this->table;
    }
    
    /**
     * Sets the value of field table
     * Column: table 
     * @param RawValue|string $table
     * @return void
     */
    public function setTable(RawValue|string $table): void
    {
        $this->table = $table;
    }
    
    /**
     * Returns the value of field primary
     * Column: primary
     * @return RawValue|int
     */
    public function getPrimary(): RawValue|int
    {
        return $this->primary;
    }
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * @param RawValue|int $primary
     * @return void
     */
    public function setPrimary(RawValue|int $primary): void
    {
        $this->primary = $primary;
    }
    
    /**
     * Returns the value of field event
     * Column: event
     * @return RawValue|string
     */
    public function getEvent(): RawValue|string
    {
        return $this->event;
    }
    
    /**
     * Sets the value of field event
     * Column: event 
     * @param RawValue|string $event
     * @return void
     */
    public function setEvent(RawValue|string $event): void
    {
        $this->event = $event;
    }
    
    /**
     * Returns the value of field column
     * Column: column
     * @return RawValue|string
     */
    public function getColumn(): RawValue|string
    {
        return $this->column;
    }
    
    /**
     * Sets the value of field column
     * Column: column 
     * @param RawValue|string $column
     * @return void
     */
    public function setColumn(RawValue|string $column): void
    {
        $this->column = $column;
    }
    
    /**
     * Returns the value of field map
     * Column: map
     * @return RawValue|string
     */
    public function getMap(): RawValue|string
    {
        return $this->map;
    }
    
    /**
     * Sets the value of field map
     * Column: map 
     * @param RawValue|string $map
     * @return void
     */
    public function setMap(RawValue|string $map): void
    {
        $this->map = $map;
    }
    
    /**
     * Returns the value of field before
     * Column: before
     * @return RawValue|string|null
     */
    public function getBefore(): RawValue|string|null
    {
        return $this->before;
    }
    
    /**
     * Sets the value of field before
     * Column: before 
     * @param RawValue|string|null $before
     * @return void
     */
    public function setBefore(RawValue|string|null $before): void
    {
        $this->before = $before;
    }
    
    /**
     * Returns the value of field after
     * Column: after
     * @return RawValue|string|null
     */
    public function getAfter(): RawValue|string|null
    {
        return $this->after;
    }
    
    /**
     * Sets the value of field after
     * Column: after 
     * @param RawValue|string|null $after
     * @return void
     */
    public function setAfter(RawValue|string|null $after): void
    {
        $this->after = $after;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string
     */
    public function getCreatedAt(): RawValue|string
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return RawValue|int|null
     */
    public function getRestoredAs(): RawValue|int|null
    {
        return $this->restoredAs;
    }
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param RawValue|int|null $restoredAs
     * @return void
     */
    public function setRestoredAs(RawValue|int|null $restoredAs): void
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
    }
    
    /**
     * Adds the default validations to the model.
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
    public function columnMap(): array {
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