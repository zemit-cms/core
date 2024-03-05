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

use Zemit\Models\Abstracts\Interfaces\JobAbstractInterface;

/**
 * Class JobAbstract
 *
 * This class defines a Job abstract model that extends the AbstractModel class and implements the JobAbstractInterface.
 * It provides properties and methods for managing Job data.
 * 
 * 
 */
abstract class JobAbstract extends AbstractModel implements JobAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: uuid
     * @var RawValue|string|null
     */
    public RawValue|string|null $uuid = null;
    
    /**
     * Column: label
     * @var RawValue|string|null
     */
    public RawValue|string|null $label = null;
    
    /**
     * Column: task
     * @var RawValue|string|null
     */
    public RawValue|string|null $task = null;
    
    /**
     * Column: action
     * @var RawValue|string|null
     */
    public RawValue|string|null $action = null;
    
    /**
     * Column: params
     * @var RawValue|string|null
     */
    public RawValue|string|null $params = null;
    
    /**
     * Column: thread
     * @var RawValue|int
     */
    public RawValue|int $thread = 0;
    
    /**
     * Column: priority
     * @var RawValue|int
     */
    public RawValue|int $priority = 0;
    
    /**
     * Column: at
     * @var RawValue|string|null
     */
    public RawValue|string|null $at = null;
    
    /**
     * Column: status
     * @var RawValue|string
     */
    public RawValue|string $status = 'new';
    
    /**
     * Column: result
     * @var RawValue|string|null
     */
    public RawValue|string|null $result = null;
    
    /**
     * Column: deleted
     * @var RawValue|int
     */
    public RawValue|int $deleted = 0;
    
    /**
     * Column: created_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $createdAt = null;
    
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
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
    /**
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
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
     * Returns the value of field uuid
     * Column: uuid
     * @return RawValue|string|null
     */
    public function getUuid(): RawValue|string|null
    {
        return $this->uuid;
    }
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param RawValue|string|null $uuid
     * @return void
     */
    public function setUuid(RawValue|string|null $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field label
     * Column: label
     * @return RawValue|string|null
     */
    public function getLabel(): RawValue|string|null
    {
        return $this->label;
    }
    
    /**
     * Sets the value of field label
     * Column: label 
     * @param RawValue|string|null $label
     * @return void
     */
    public function setLabel(RawValue|string|null $label): void
    {
        $this->label = $label;
    }
    
    /**
     * Returns the value of field task
     * Column: task
     * @return RawValue|string|null
     */
    public function getTask(): RawValue|string|null
    {
        return $this->task;
    }
    
    /**
     * Sets the value of field task
     * Column: task 
     * @param RawValue|string|null $task
     * @return void
     */
    public function setTask(RawValue|string|null $task): void
    {
        $this->task = $task;
    }
    
    /**
     * Returns the value of field action
     * Column: action
     * @return RawValue|string|null
     */
    public function getAction(): RawValue|string|null
    {
        return $this->action;
    }
    
    /**
     * Sets the value of field action
     * Column: action 
     * @param RawValue|string|null $action
     * @return void
     */
    public function setAction(RawValue|string|null $action): void
    {
        $this->action = $action;
    }
    
    /**
     * Returns the value of field params
     * Column: params
     * @return RawValue|string|null
     */
    public function getParams(): RawValue|string|null
    {
        return $this->params;
    }
    
    /**
     * Sets the value of field params
     * Column: params 
     * @param RawValue|string|null $params
     * @return void
     */
    public function setParams(RawValue|string|null $params): void
    {
        $this->params = $params;
    }
    
    /**
     * Returns the value of field thread
     * Column: thread
     * @return RawValue|int
     */
    public function getThread(): RawValue|int
    {
        return $this->thread;
    }
    
    /**
     * Sets the value of field thread
     * Column: thread 
     * @param RawValue|int $thread
     * @return void
     */
    public function setThread(RawValue|int $thread): void
    {
        $this->thread = $thread;
    }
    
    /**
     * Returns the value of field priority
     * Column: priority
     * @return RawValue|int
     */
    public function getPriority(): RawValue|int
    {
        return $this->priority;
    }
    
    /**
     * Sets the value of field priority
     * Column: priority 
     * @param RawValue|int $priority
     * @return void
     */
    public function setPriority(RawValue|int $priority): void
    {
        $this->priority = $priority;
    }
    
    /**
     * Returns the value of field at
     * Column: at
     * @return RawValue|string|null
     */
    public function getAt(): RawValue|string|null
    {
        return $this->at;
    }
    
    /**
     * Sets the value of field at
     * Column: at 
     * @param RawValue|string|null $at
     * @return void
     */
    public function setAt(RawValue|string|null $at): void
    {
        $this->at = $at;
    }
    
    /**
     * Returns the value of field status
     * Column: status
     * @return RawValue|string
     */
    public function getStatus(): RawValue|string
    {
        return $this->status;
    }
    
    /**
     * Sets the value of field status
     * Column: status 
     * @param RawValue|string $status
     * @return void
     */
    public function setStatus(RawValue|string $status): void
    {
        $this->status = $status;
    }
    
    /**
     * Returns the value of field result
     * Column: result
     * @return RawValue|string|null
     */
    public function getResult(): RawValue|string|null
    {
        return $this->result;
    }
    
    /**
     * Sets the value of field result
     * Column: result 
     * @param RawValue|string|null $result
     * @return void
     */
    public function setResult(RawValue|string|null $result): void
    {
        $this->result = $result;
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
     * @return RawValue|string|null
     */
    public function getCreatedAt(): RawValue|string|null
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string|null $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string|null $createdAt): void
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
        // no default relationship found
    }
    
    /**
     * Adds the default validations to the model.
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addStringLengthValidation($validator, 'uuid', 0, 36, false);
        $this->addStringLengthValidation($validator, 'label', 0, 100, true);
        $this->addStringLengthValidation($validator, 'task', 0, 100, false);
        $this->addStringLengthValidation($validator, 'action', 0, 100, false);
        $this->addJsonValidation($validator, 'params', true);
        $this->addUnsignedIntValidation($validator, 'thread', false);
        $this->addUnsignedIntValidation($validator, 'priority', false);
        $this->addDateTimeValidation($validator, 'at', true);
        $this->addInclusionInValidation($validator, 'status', ['new','progress','failed','finished'], false);
        $this->addJsonValidation($validator, 'result', true);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
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
            'uuid' => 'uuid',
            'label' => 'label',
            'task' => 'task',
            'action' => 'action',
            'params' => 'params',
            'thread' => 'thread',
            'priority' => 'priority',
            'at' => 'at',
            'status' => 'status',
            'result' => 'result',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_as' => 'deletedAs',
            'deleted_by' => 'deletedBy',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
            'restored_as' => 'restoredAs',
        ];
    }
}