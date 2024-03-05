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

use Zemit\Mvc\ModelInterface;

interface JobInterface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return ?int
     */
    public function getId(): ?int;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param ?int $id
     * @return void
     */
    public function setId(?int $id): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * @return string
     */
    public function getUuid(): string;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param string $uuid
     * @return void
     */
    public function setUuid(string $uuid): void;
    
    /**
     * Returns the value of field label
     * Column: label
     * @return ?string
     */
    public function getLabel(): ?string;
    
    /**
     * Sets the value of field label
     * Column: label 
     * @param ?string $label
     * @return void
     */
    public function setLabel(?string $label): void;
    
    /**
     * Returns the value of field task
     * Column: task
     * @return string
     */
    public function getTask(): string;
    
    /**
     * Sets the value of field task
     * Column: task 
     * @param string $task
     * @return void
     */
    public function setTask(string $task): void;
    
    /**
     * Returns the value of field action
     * Column: action
     * @return string
     */
    public function getAction(): string;
    
    /**
     * Sets the value of field action
     * Column: action 
     * @param string $action
     * @return void
     */
    public function setAction(string $action): void;
    
    /**
     * Returns the value of field params
     * Column: params
     * @return ?string
     */
    public function getParams(): ?string;
    
    /**
     * Sets the value of field params
     * Column: params 
     * @param ?string $params
     * @return void
     */
    public function setParams(?string $params): void;
    
    /**
     * Returns the value of field thread
     * Column: thread
     * @return int
     */
    public function getThread(): int;
    
    /**
     * Sets the value of field thread
     * Column: thread 
     * @param int $thread
     * @return void
     */
    public function setThread(int $thread): void;
    
    /**
     * Returns the value of field priority
     * Column: priority
     * @return int
     */
    public function getPriority(): int;
    
    /**
     * Sets the value of field priority
     * Column: priority 
     * @param int $priority
     * @return void
     */
    public function setPriority(int $priority): void;
    
    /**
     * Returns the value of field at
     * Column: at
     * @return ?string
     */
    public function getAt(): ?string;
    
    /**
     * Sets the value of field at
     * Column: at 
     * @param ?string $at
     * @return void
     */
    public function setAt(?string $at): void;
    
    /**
     * Returns the value of field status
     * Column: status
     * @return string
     */
    public function getStatus(): string;
    
    /**
     * Sets the value of field status
     * Column: status 
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void;
    
    /**
     * Returns the value of field result
     * Column: result
     * @return ?string
     */
    public function getResult(): ?string;
    
    /**
     * Sets the value of field result
     * Column: result 
     * @param ?string $result
     * @return void
     */
    public function setResult(?string $result): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return int
     */
    public function getDeleted(): int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param int $deleted
     * @return void
     */
    public function setDeleted(int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return string
     */
    public function getCreatedAt(): string;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return ?int
     */
    public function getCreatedBy(): ?int;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param ?int $createdBy
     * @return void
     */
    public function setCreatedBy(?int $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return ?int
     */
    public function getCreatedAs(): ?int;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param ?int $createdAs
     * @return void
     */
    public function setCreatedAs(?int $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return ?string
     */
    public function getUpdatedAt(): ?string;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param ?string $updatedAt
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return ?int
     */
    public function getUpdatedBy(): ?int;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param ?int $updatedBy
     * @return void
     */
    public function setUpdatedBy(?int $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return ?int
     */
    public function getUpdatedAs(): ?int;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param ?int $updatedAs
     * @return void
     */
    public function setUpdatedAs(?int $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return ?string
     */
    public function getDeletedAt(): ?string;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param ?string $deletedAt
     * @return void
     */
    public function setDeletedAt(?string $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return ?int
     */
    public function getDeletedAs(): ?int;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param ?int $deletedAs
     * @return void
     */
    public function setDeletedAs(?int $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return ?int
     */
    public function getDeletedBy(): ?int;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param ?int $deletedBy
     * @return void
     */
    public function setDeletedBy(?int $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return ?string
     */
    public function getRestoredAt(): ?string;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param ?string $restoredAt
     * @return void
     */
    public function setRestoredAt(?string $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return ?int
     */
    public function getRestoredBy(): ?int;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param ?int $restoredBy
     * @return void
     */
    public function setRestoredBy(?int $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return ?int
     */
    public function getRestoredAs(): ?int;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param ?int $restoredAs
     * @return void
     */
    public function setRestoredAs(?int $restoredAs): void;
}