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
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @var mixed
     */
    public $uuid = null;
        
    /**
     * Column: label
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public $label = null;
        
    /**
     * Column: task
     * Attributes: NotNull | Size(100) | Type(5)
     * @var mixed
     */
    public $task = null;
        
    /**
     * Column: action
     * Attributes: NotNull | Size(100) | Type(5)
     * @var mixed
     */
    public $action = null;
        
    /**
     * Column: params
     * Attributes: Type(15)
     * @var mixed
     */
    public $params = null;
        
    /**
     * Column: thread
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public $thread = 0;
        
    /**
     * Column: priority
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public $priority = 0;
        
    /**
     * Column: at
     * Attributes: Type(4)
     * @var mixed
     */
    public $at = null;
        
    /**
     * Column: status
     * Attributes: NotNull | Size('new','progress','failed','finished') | Type(18)
     * @var mixed
     */
    public $status = 'new';
        
    /**
     * Column: result
     * Attributes: Type(15)
     * @var mixed
     */
    public $result = null;
        
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
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedBy = null;
        
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
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid()
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
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field label
     * Column: label
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: Size(100) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * Returns the value of field task
     * Column: task
     * Attributes: NotNull | Size(100) | Type(5)
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }
    
    /**
     * Sets the value of field task
     * Column: task 
     * Attributes: NotNull | Size(100) | Type(5)
     * @param mixed $task
     * @return void
     */
    public function setTask($task)
    {
        $this->task = $task;
    }
    
    /**
     * Returns the value of field action
     * Column: action
     * Attributes: NotNull | Size(100) | Type(5)
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * Sets the value of field action
     * Column: action 
     * Attributes: NotNull | Size(100) | Type(5)
     * @param mixed $action
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    /**
     * Returns the value of field params
     * Column: params
     * Attributes: Type(15)
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Sets the value of field params
     * Column: params 
     * Attributes: Type(15)
     * @param mixed $params
     * @return void
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
    
    /**
     * Returns the value of field thread
     * Column: thread
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getThread()
    {
        return $this->thread;
    }
    
    /**
     * Sets the value of field thread
     * Column: thread 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $thread
     * @return void
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }
    
    /**
     * Returns the value of field priority
     * Column: priority
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    /**
     * Sets the value of field priority
     * Column: priority 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $priority
     * @return void
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
    
    /**
     * Returns the value of field at
     * Column: at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getAt()
    {
        return $this->at;
    }
    
    /**
     * Sets the value of field at
     * Column: at 
     * Attributes: Type(4)
     * @param mixed $at
     * @return void
     */
    public function setAt($at)
    {
        $this->at = $at;
    }
    
    /**
     * Returns the value of field status
     * Column: status
     * Attributes: NotNull | Size('new','progress','failed','finished') | Type(18)
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Sets the value of field status
     * Column: status 
     * Attributes: NotNull | Size('new','progress','failed','finished') | Type(18)
     * @param mixed $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Returns the value of field result
     * Column: result
     * Attributes: Type(15)
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Sets the value of field result
     * Column: result 
     * Attributes: Type(15)
     * @param mixed $result
     * @return void
     */
    public function setResult($result)
    {
        $this->result = $result;
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
        // no default relationship found
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