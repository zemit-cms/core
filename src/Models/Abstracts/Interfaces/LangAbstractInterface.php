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
 * @property CategoryAbstractInterface[] $categorylist
 * @property CategoryAbstractInterface[] $CategoryList
 * @method CategoryAbstractInterface[] getCategoryList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $CategorySiteList
 * @method SiteAbstractInterface[] getCategorySiteList(?array $params = null)
 *
 * @property FlagAbstractInterface[] $flaglist
 * @property FlagAbstractInterface[] $FlagList
 * @method FlagAbstractInterface[] getFlagList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $FlagSiteList
 * @method SiteAbstractInterface[] getFlagSiteList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $FlagPageList
 * @method PageAbstractInterface[] getFlagPageList(?array $params = null)
 *
 * @property MetaAbstractInterface[] $metalist
 * @property MetaAbstractInterface[] $MetaList
 * @method MetaAbstractInterface[] getMetaList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $MetaSiteList
 * @method SiteAbstractInterface[] getMetaSiteList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $MetaPageList
 * @method PageAbstractInterface[] getMetaPageList(?array $params = null)
 *
 * @property PostAbstractInterface[] $postlist
 * @property PostAbstractInterface[] $MetaPostList
 * @method PostAbstractInterface[] getMetaPostList(?array $params = null)
 *
 * @property CategoryAbstractInterface[] $categorylist
 * @property CategoryAbstractInterface[] $MetaCategoryList
 * @method CategoryAbstractInterface[] getMetaCategoryList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $PageList
 * @method PageAbstractInterface[] getPageList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $PageSiteList
 * @method SiteAbstractInterface[] getPageSiteList(?array $params = null)
 *
 * @property PostAbstractInterface[] $postlist
 * @property PostAbstractInterface[] $PostList
 * @method PostAbstractInterface[] getPostList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $PostSiteList
 * @method SiteAbstractInterface[] getPostSiteList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $PostPageList
 * @method PageAbstractInterface[] getPostPageList(?array $params = null)
 *
 * @property SiteLangAbstractInterface[] $sitelanglist
 * @property SiteLangAbstractInterface[] $SiteLangList
 * @method SiteLangAbstractInterface[] getSiteLangList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $SiteList
 * @method SiteAbstractInterface[] getSiteList(?array $params = null)
 *
 * @property TableAbstractInterface[] $tablelist
 * @property TableAbstractInterface[] $TableList
 * @method TableAbstractInterface[] getTableList(?array $params = null)
 *
 * @property WorkspaceAbstractInterface[] $workspacelist
 * @property WorkspaceAbstractInterface[] $TableWorkspaceList
 * @method WorkspaceAbstractInterface[] getTableWorkspaceList(?array $params = null)
 *
 * @property TranslateAbstractInterface[] $translatelist
 * @property TranslateAbstractInterface[] $TranslateList
 * @method TranslateAbstractInterface[] getTranslateList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $TranslateSiteList
 * @method SiteAbstractInterface[] getTranslateSiteList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $TranslatePageList
 * @method PageAbstractInterface[] getTranslatePageList(?array $params = null)
 *
 * @property PostAbstractInterface[] $postlist
 * @property PostAbstractInterface[] $TranslatePostList
 * @method PostAbstractInterface[] getTranslatePostList(?array $params = null)
 *
 * @property CategoryAbstractInterface[] $categorylist
 * @property CategoryAbstractInterface[] $TranslateCategoryList
 * @method CategoryAbstractInterface[] getTranslateCategoryList(?array $params = null)
 *
 * @property TranslateFieldAbstractInterface[] $translatefieldlist
 * @property TranslateFieldAbstractInterface[] $TranslateFieldList
 * @method TranslateFieldAbstractInterface[] getTranslateFieldList(?array $params = null)
 *
 * @property SiteAbstractInterface[] $sitelist
 * @property SiteAbstractInterface[] $TranslateFieldSiteList
 * @method SiteAbstractInterface[] getTranslateFieldSiteList(?array $params = null)
 *
 * @property TableAbstractInterface[] $tablelist
 * @property TableAbstractInterface[] $TranslateFieldTableList
 * @method TableAbstractInterface[] getTranslateFieldTableList(?array $params = null)
 *
 * @property WorkspaceLangAbstractInterface[] $workspacelanglist
 * @property WorkspaceLangAbstractInterface[] $WorkspaceLangList
 * @method WorkspaceLangAbstractInterface[] getWorkspaceLangList(?array $params = null)
 *
 * @property WorkspaceAbstractInterface[] $workspacelist
 * @property WorkspaceAbstractInterface[] $WorkspaceList
 * @method WorkspaceAbstractInterface[] getWorkspaceList(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdasentity
 * @property UserAbstractInterface $CreatedAsEntity
 * @method UserAbstractInterface getCreatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedbyentity
 * @property UserAbstractInterface $UpdatedByEntity
 * @method UserAbstractInterface getUpdatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedasentity
 * @property UserAbstractInterface $UpdatedAsEntity
 * @method UserAbstractInterface getUpdatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedasentity
 * @property UserAbstractInterface $DeletedAsEntity
 * @method UserAbstractInterface getDeletedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedbyentity
 * @property UserAbstractInterface $DeletedByEntity
 * @method UserAbstractInterface getDeletedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $restoredbyentity
 * @property UserAbstractInterface $RestoredByEntity
 * @method UserAbstractInterface getRestoredByEntity(?array $params = null)
 */
interface LangAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of field label
     * Column: label
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getLabel(): mixed;
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel(mixed $label): void;
    
    /**
     * Returns the value of field code
     * Column: code
     * Attributes: NotNull | Size(10) | Type(5)
     * @return mixed
     */
    public function getCode(): mixed;
    
    /**
     * Sets the value of field code
     * Column: code 
     * Attributes: NotNull | Size(10) | Type(5)
     * @param mixed $code
     * @return void
     */
    public function setCode(mixed $code): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void;
    
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
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt(mixed $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs(mixed $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt(mixed $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs(mixed $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt(mixed $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy(mixed $restoredBy): void;
}