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

namespace Zemit\Models\Abstracts\Interfaces;

use Phalcon\Db\RawValue;
use Zemit\Mvc\ModelInterface;

interface JobAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId();
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id);
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid();
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid($uuid);
    
    /**
     * Returns the value of field label
     * Column: label
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getLabel();
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: Size(100) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel($label);
    
    /**
     * Returns the value of field task
     * Column: task
     * Attributes: NotNull | Size(100) | Type(5)
     * @return mixed
     */
    public function getTask();
    
    /**
     * Sets the value of field task
     * Column: task 
     * Attributes: NotNull | Size(100) | Type(5)
     * @param mixed $task
     * @return void
     */
    public function setTask($task);
    
    /**
     * Returns the value of field action
     * Column: action
     * Attributes: NotNull | Size(100) | Type(5)
     * @return mixed
     */
    public function getAction();
    
    /**
     * Sets the value of field action
     * Column: action 
     * Attributes: NotNull | Size(100) | Type(5)
     * @param mixed $action
     * @return void
     */
    public function setAction($action);
    
    /**
     * Returns the value of field params
     * Column: params
     * Attributes: Type(15)
     * @return mixed
     */
    public function getParams();
    
    /**
     * Sets the value of field params
     * Column: params 
     * Attributes: Type(15)
     * @param mixed $params
     * @return void
     */
    public function setParams($params);
    
    /**
     * Returns the value of field thread
     * Column: thread
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getThread();
    
    /**
     * Sets the value of field thread
     * Column: thread 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $thread
     * @return void
     */
    public function setThread($thread);
    
    /**
     * Returns the value of field priority
     * Column: priority
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPriority();
    
    /**
     * Sets the value of field priority
     * Column: priority 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $priority
     * @return void
     */
    public function setPriority($priority);
    
    /**
     * Returns the value of field at
     * Column: at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getAt();
    
    /**
     * Sets the value of field at
     * Column: at 
     * Attributes: Type(4)
     * @param mixed $at
     * @return void
     */
    public function setAt($at);
    
    /**
     * Returns the value of field status
     * Column: status
     * Attributes: NotNull | Size('new','progress','failed','finished') | Type(18)
     * @return mixed
     */
    public function getStatus();
    
    /**
     * Sets the value of field status
     * Column: status 
     * Attributes: NotNull | Size('new','progress','failed','finished') | Type(18)
     * @param mixed $status
     * @return void
     */
    public function setStatus($status);
    
    /**
     * Returns the value of field result
     * Column: result
     * Attributes: Type(15)
     * @return mixed
     */
    public function getResult();
    
    /**
     * Sets the value of field result
     * Column: result 
     * Attributes: Type(15)
     * @param mixed $result
     * @return void
     */
    public function setResult($result);
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted();
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted($deleted);
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt();
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt);
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy();
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy($createdBy);
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs();
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs($createdAs);
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt();
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt);
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy();
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy($updatedBy);
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs();
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs($updatedAs);
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt();
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt($deletedAt);
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs();
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs($deletedAs);
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy();
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy($deletedBy);
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt();
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt($restoredAt);
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy();
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy($restoredBy);
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs();
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs($restoredAs);
}