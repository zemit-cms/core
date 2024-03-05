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
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * @return RawValue|string|null
     */
    public function getUuid(): RawValue|string|null;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param RawValue|string|null $uuid
     * @return void
     */
    public function setUuid(RawValue|string|null $uuid): void;
    
    /**
     * Returns the value of field label
     * Column: label
     * @return RawValue|string|null
     */
    public function getLabel(): RawValue|string|null;
    
    /**
     * Sets the value of field label
     * Column: label 
     * @param RawValue|string|null $label
     * @return void
     */
    public function setLabel(RawValue|string|null $label): void;
    
    /**
     * Returns the value of field task
     * Column: task
     * @return RawValue|string|null
     */
    public function getTask(): RawValue|string|null;
    
    /**
     * Sets the value of field task
     * Column: task 
     * @param RawValue|string|null $task
     * @return void
     */
    public function setTask(RawValue|string|null $task): void;
    
    /**
     * Returns the value of field action
     * Column: action
     * @return RawValue|string|null
     */
    public function getAction(): RawValue|string|null;
    
    /**
     * Sets the value of field action
     * Column: action 
     * @param RawValue|string|null $action
     * @return void
     */
    public function setAction(RawValue|string|null $action): void;
    
    /**
     * Returns the value of field params
     * Column: params
     * @return RawValue|string|null
     */
    public function getParams(): RawValue|string|null;
    
    /**
     * Sets the value of field params
     * Column: params 
     * @param RawValue|string|null $params
     * @return void
     */
    public function setParams(RawValue|string|null $params): void;
    
    /**
     * Returns the value of field thread
     * Column: thread
     * @return RawValue|int
     */
    public function getThread(): RawValue|int;
    
    /**
     * Sets the value of field thread
     * Column: thread 
     * @param RawValue|int $thread
     * @return void
     */
    public function setThread(RawValue|int $thread): void;
    
    /**
     * Returns the value of field priority
     * Column: priority
     * @return RawValue|int
     */
    public function getPriority(): RawValue|int;
    
    /**
     * Sets the value of field priority
     * Column: priority 
     * @param RawValue|int $priority
     * @return void
     */
    public function setPriority(RawValue|int $priority): void;
    
    /**
     * Returns the value of field at
     * Column: at
     * @return RawValue|string|null
     */
    public function getAt(): RawValue|string|null;
    
    /**
     * Sets the value of field at
     * Column: at 
     * @param RawValue|string|null $at
     * @return void
     */
    public function setAt(RawValue|string|null $at): void;
    
    /**
     * Returns the value of field status
     * Column: status
     * @return RawValue|string
     */
    public function getStatus(): RawValue|string;
    
    /**
     * Sets the value of field status
     * Column: status 
     * @param RawValue|string $status
     * @return void
     */
    public function setStatus(RawValue|string $status): void;
    
    /**
     * Returns the value of field result
     * Column: result
     * @return RawValue|string|null
     */
    public function getResult(): RawValue|string|null;
    
    /**
     * Sets the value of field result
     * Column: result 
     * @param RawValue|string|null $result
     * @return void
     */
    public function setResult(RawValue|string|null $result): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string|null
     */
    public function getCreatedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string|null $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string|null $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return RawValue|int|null
     */
    public function getRestoredAs(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param RawValue|int|null $restoredAs
     * @return void
     */
    public function setRestoredAs(RawValue|int|null $restoredAs): void;
}