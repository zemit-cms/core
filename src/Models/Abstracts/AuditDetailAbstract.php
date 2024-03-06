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
 * Class AuditDetailAbstract
 *
 * This class defines a AuditDetail abstract model that extends the AbstractModel class and implements the AuditDetailAbstractInterface.
 * It provides properties and methods for managing AuditDetail data.
 * 
 * @property Audit $AuditEntity
 * @method Audit getAuditEntity(?array $params = null)
 */
abstract class AuditDetailAbstract extends AbstractModel implements AuditDetailAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: audit_id
     * Attributes: NotNull | Numeric | Unsigned | Type(14)
     * @var mixed
     */
    public $auditId = null;
        
    /**
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public $model = null;
        
    /**
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public $table = null;
        
    /**
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public $primary = null;
        
    /**
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @var mixed
     */
    public $event = 'other';
        
    /**
     * Column: column
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public $column = null;
        
    /**
     * Column: map
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public $map = null;
        
    /**
     * Column: before
     * Attributes: Type(23)
     * @var mixed
     */
    public $before = null;
        
    /**
     * Column: after
     * Attributes: Type(23)
     * @var mixed
     */
    public $after = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $deletedAt = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedBy = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedAs = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredBy = null;
        
    /**
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredAs = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @return mixed
     */
    public function getId()
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
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field auditId
     * Column: audit_id
     * Attributes: NotNull | Numeric | Unsigned | Type(14)
     * @return mixed
     */
    public function getAuditId()
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
    public function setAuditId($auditId)
    {
        $this->auditId = $auditId;
    }
    
    /**
     * Returns the value of field model
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getModel()
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
    public function setModel($model)
    {
        $this->model = $model;
    }
    
    /**
     * Returns the value of field table
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getTable()
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
    public function setTable($table)
    {
        $this->table = $table;
    }
    
    /**
     * Returns the value of field primary
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPrimary()
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
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
    
    /**
     * Returns the value of field event
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @return mixed
     */
    public function getEvent()
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
    public function setEvent($event)
    {
        $this->event = $event;
    }
    
    /**
     * Returns the value of field column
     * Column: column
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getColumn()
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
    public function setColumn($column)
    {
        $this->column = $column;
    }
    
    /**
     * Returns the value of field map
     * Column: map
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getMap()
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
    public function setMap($map)
    {
        $this->map = $map;
    }
    
    /**
     * Returns the value of field before
     * Column: before
     * Attributes: Type(23)
     * @return mixed
     */
    public function getBefore()
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
    public function setBefore($before)
    {
        $this->before = $before;
    }
    
    /**
     * Returns the value of field after
     * Column: after
     * Attributes: Type(23)
     * @return mixed
     */
    public function getAfter()
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
    public function setAfter($after)
    {
        $this->after = $after;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted()
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
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt()
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
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy()
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
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs()
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
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt()
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
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy()
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
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs()
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
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt()
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
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy()
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
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs()
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
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt()
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
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy()
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
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs()
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
    public function setRestoredAs($restoredAs)
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