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
use Zemit\Models\Table;
use Zemit\Models\Lang;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\Abstracts\Interfaces\WorkspaceAbstractInterface;

/**
 * Class WorkspaceAbstract
 *
 * This class defines a Workspace abstract model that extends the AbstractModel class and implements the WorkspaceAbstractInterface.
 * It provides properties and methods for managing Workspace data.
 * 
 * @property Table[] $TableList
 * @method Table[] getTableList(?array $params = null)
 *
 * @property Lang[] $TableLangList
 * @method Lang[] getTableLangList(?array $params = null)
 *
 * @property WorkspaceLang[] $WorkspaceLangList
 * @method WorkspaceLang[] getWorkspaceLangList(?array $params = null)
 *
 * @property Lang[] $LangList
 * @method Lang[] getLangList(?array $params = null)
 */
abstract class WorkspaceAbstract extends AbstractModel implements WorkspaceAbstractInterface
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
     * Column: name
     * @var RawValue|string|null
     */
    public RawValue|string|null $name = null;
    
    /**
     * Column: description
     * @var RawValue|string|null
     */
    public RawValue|string|null $description = null;
    
    /**
     * Column: icon
     * @var RawValue|string|null
     */
    public RawValue|string|null $icon = null;
    
    /**
     * Column: color
     * @var RawValue|string|null
     */
    public RawValue|string|null $color = null;
    
    /**
     * Column: status
     * @var RawValue|string
     */
    public RawValue|string $status = 'active';
    
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
     * Returns the value of field name
     * Column: name
     * @return RawValue|string|null
     */
    public function getName(): RawValue|string|null
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param RawValue|string|null $name
     * @return void
     */
    public function setName(RawValue|string|null $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field description
     * Column: description
     * @return RawValue|string|null
     */
    public function getDescription(): RawValue|string|null
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * @param RawValue|string|null $description
     * @return void
     */
    public function setDescription(RawValue|string|null $description): void
    {
        $this->description = $description;
    }
    
    /**
     * Returns the value of field icon
     * Column: icon
     * @return RawValue|string|null
     */
    public function getIcon(): RawValue|string|null
    {
        return $this->icon;
    }
    
    /**
     * Sets the value of field icon
     * Column: icon 
     * @param RawValue|string|null $icon
     * @return void
     */
    public function setIcon(RawValue|string|null $icon): void
    {
        $this->icon = $icon;
    }
    
    /**
     * Returns the value of field color
     * Column: color
     * @return RawValue|string|null
     */
    public function getColor(): RawValue|string|null
    {
        return $this->color;
    }
    
    /**
     * Sets the value of field color
     * Column: color 
     * @param RawValue|string|null $color
     * @return void
     */
    public function setColor(RawValue|string|null $color): void
    {
        $this->color = $color;
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
        $this->hasMany('id', Table::class, 'workspaceId', ['alias' => 'TableList']);

        $this->hasManyToMany('id', Table::class, 'workspaceId',
            'langId', Lang::class, 'id', ['alias' => 'TableLangList']);

        $this->hasMany('id', WorkspaceLang::class, 'workspaceId', ['alias' => 'WorkspaceLangList']);

        $this->hasManyToMany('id', WorkspaceLang::class, 'workspaceId',
            'langId', Lang::class, 'id', ['alias' => 'LangList']);
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
        $this->addStringLengthValidation($validator, 'name', 0, 60, false);
        $this->addStringLengthValidation($validator, 'description', 0, 240, true);
        $this->addStringLengthValidation($validator, 'icon', 0, 64, true);
        $this->addStringLengthValidation($validator, 'color', 0, 9, true);
        $this->addInclusionInValidation($validator, 'status', ['active','inactive'], false);
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
            'name' => 'name',
            'description' => 'description',
            'icon' => 'icon',
            'color' => 'color',
            'status' => 'status',
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