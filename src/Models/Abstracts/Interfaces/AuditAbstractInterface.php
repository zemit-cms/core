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

/**
 * @property AuditDetailAbstractInterface[] $auditdetaillist
 * @property AuditDetailAbstractInterface[] $AuditDetailList
 * @method AuditDetailAbstractInterface[] getAuditDetailList(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdasentity
 * @property UserAbstractInterface $CreatedAsEntity
 * @method UserAbstractInterface getCreatedAsEntity(?array $params = null)
 */
interface AuditAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void;
    
    /**
     * Returns the value of field model
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getModel(): mixed;
    
    /**
     * Sets the value of field model
     * Column: model 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $model
     * @return void
     */
    public function setModel(mixed $model): void;
    
    /**
     * Returns the value of field table
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getTable(): mixed;
    
    /**
     * Sets the value of field table
     * Column: table 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $table
     * @return void
     */
    public function setTable(mixed $table): void;
    
    /**
     * Returns the value of field primary
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getPrimary(): mixed;
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $primary
     * @return void
     */
    public function setPrimary(mixed $primary): void;
    
    /**
     * Returns the value of field event
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @return mixed
     */
    public function getEvent(): mixed;
    
    /**
     * Sets the value of field event
     * Column: event 
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @param mixed $event
     * @return void
     */
    public function setEvent(mixed $event): void;
    
    /**
     * Returns the value of field before
     * Column: before
     * Attributes: Type(24)
     * @return mixed
     */
    public function getBefore(): mixed;
    
    /**
     * Sets the value of field before
     * Column: before 
     * Attributes: Type(24)
     * @param mixed $before
     * @return void
     */
    public function setBefore(mixed $before): void;
    
    /**
     * Returns the value of field after
     * Column: after
     * Attributes: Type(24)
     * @return mixed
     */
    public function getAfter(): mixed;
    
    /**
     * Sets the value of field after
     * Column: after 
     * Attributes: Type(24)
     * @param mixed $after
     * @return void
     */
    public function setAfter(mixed $after): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedAs(): mixed;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void;
}
