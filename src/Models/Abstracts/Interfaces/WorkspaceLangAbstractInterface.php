<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Models\Abstracts\Interfaces;

use Phalcon\Db\RawValue;
use PhalconKit\Mvc\ModelInterface;

/**
 * @property WorkspaceAbstractInterface $workspaceentity
 * @property WorkspaceAbstractInterface $WorkspaceEntity
 * @method WorkspaceAbstractInterface getWorkspaceEntity(?array $params = null)
 *
 * @property LangAbstractInterface $langentity
 * @property LangAbstractInterface $LangEntity
 * @method LangAbstractInterface getLangEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 */
interface WorkspaceLangAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of the field "id"
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of the field "id"
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of the field "uuid"
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed;
    
    /**
     * Sets the value of the field "uuid"
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void;
    
    /**
     * Returns the value of the field "workspaceId"
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getWorkspaceId(): mixed;
    
    /**
     * Sets the value of the field "workspaceId"
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $workspaceId
     * @return void
     */
    public function setWorkspaceId(mixed $workspaceId): void;
    
    /**
     * Returns the value of the field "langId"
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @return mixed
     */
    public function getLangId(): mixed;
    
    /**
     * Sets the value of the field "langId"
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @param mixed $langId
     * @return void
     */
    public function setLangId(mixed $langId): void;
    
    /**
     * Returns the value of the field "deleted"
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of the field "deleted"
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void;
    
    /**
     * Returns the value of the field "createdAt"
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed;
    
    /**
     * Sets the value of the field "createdAt"
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void;
    
    /**
     * Returns the value of the field "createdBy"
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of the field "createdBy"
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
}
