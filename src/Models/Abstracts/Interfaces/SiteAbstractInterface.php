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
 * @property LangAbstractInterface[] $categorylanglist
 * @property LangAbstractInterface[] $CategoryLangList
 * @method LangAbstractInterface[] getCategoryLangList(?array $params = null)
 *
 * @property DataAbstractInterface[] $datalist
 * @property DataAbstractInterface[] $DataList
 * @method DataAbstractInterface[] getDataList(?array $params = null)
 *
 * @property TableAbstractInterface[] $datatablelist
 * @property TableAbstractInterface[] $DataTableList
 * @method TableAbstractInterface[] getDataTableList(?array $params = null)
 *
 * @property FieldAbstractInterface[] $datafieldlist
 * @property FieldAbstractInterface[] $DataFieldList
 * @method FieldAbstractInterface[] getDataFieldList(?array $params = null)
 *
 * @property FieldAbstractInterface[] $fieldlist
 * @property FieldAbstractInterface[] $FieldList
 * @method FieldAbstractInterface[] getFieldList(?array $params = null)
 *
 * @property TableAbstractInterface[] $fieldtablelist
 * @property TableAbstractInterface[] $FieldTableList
 * @method TableAbstractInterface[] getFieldTableList(?array $params = null)
 *
 * @property FlagAbstractInterface[] $flaglist
 * @property FlagAbstractInterface[] $FlagList
 * @method FlagAbstractInterface[] getFlagList(?array $params = null)
 *
 * @property PageAbstractInterface[] $flagpagelist
 * @property PageAbstractInterface[] $FlagPageList
 * @method PageAbstractInterface[] getFlagPageList(?array $params = null)
 *
 * @property LangAbstractInterface[] $flaglanglist
 * @property LangAbstractInterface[] $FlagLangList
 * @method LangAbstractInterface[] getFlagLangList(?array $params = null)
 *
 * @property MetaAbstractInterface[] $metalist
 * @property MetaAbstractInterface[] $MetaList
 * @method MetaAbstractInterface[] getMetaList(?array $params = null)
 *
 * @property LangAbstractInterface[] $metalanglist
 * @property LangAbstractInterface[] $MetaLangList
 * @method LangAbstractInterface[] getMetaLangList(?array $params = null)
 *
 * @property PageAbstractInterface[] $metapagelist
 * @property PageAbstractInterface[] $MetaPageList
 * @method PageAbstractInterface[] getMetaPageList(?array $params = null)
 *
 * @property PostAbstractInterface[] $metapostlist
 * @property PostAbstractInterface[] $MetaPostList
 * @method PostAbstractInterface[] getMetaPostList(?array $params = null)
 *
 * @property CategoryAbstractInterface[] $metacategorylist
 * @property CategoryAbstractInterface[] $MetaCategoryList
 * @method CategoryAbstractInterface[] getMetaCategoryList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $PageList
 * @method PageAbstractInterface[] getPageList(?array $params = null)
 *
 * @property LangAbstractInterface[] $pagelanglist
 * @property LangAbstractInterface[] $PageLangList
 * @method LangAbstractInterface[] getPageLangList(?array $params = null)
 *
 * @property PostAbstractInterface[] $postlist
 * @property PostAbstractInterface[] $PostList
 * @method PostAbstractInterface[] getPostList(?array $params = null)
 *
 * @property LangAbstractInterface[] $postlanglist
 * @property LangAbstractInterface[] $PostLangList
 * @method LangAbstractInterface[] getPostLangList(?array $params = null)
 *
 * @property PageAbstractInterface[] $postpagelist
 * @property PageAbstractInterface[] $PostPageList
 * @method PageAbstractInterface[] getPostPageList(?array $params = null)
 *
 * @property SiteLangAbstractInterface[] $sitelanglist
 * @property SiteLangAbstractInterface[] $SiteLangList
 * @method SiteLangAbstractInterface[] getSiteLangList(?array $params = null)
 *
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $LangList
 * @method LangAbstractInterface[] getLangList(?array $params = null)
 *
 * @property TranslateAbstractInterface[] $translatelist
 * @property TranslateAbstractInterface[] $TranslateList
 * @method TranslateAbstractInterface[] getTranslateList(?array $params = null)
 *
 * @property LangAbstractInterface[] $translatelanglist
 * @property LangAbstractInterface[] $TranslateLangList
 * @method LangAbstractInterface[] getTranslateLangList(?array $params = null)
 *
 * @property PageAbstractInterface[] $translatepagelist
 * @property PageAbstractInterface[] $TranslatePageList
 * @method PageAbstractInterface[] getTranslatePageList(?array $params = null)
 *
 * @property PostAbstractInterface[] $translatepostlist
 * @property PostAbstractInterface[] $TranslatePostList
 * @method PostAbstractInterface[] getTranslatePostList(?array $params = null)
 *
 * @property CategoryAbstractInterface[] $translatecategorylist
 * @property CategoryAbstractInterface[] $TranslateCategoryList
 * @method CategoryAbstractInterface[] getTranslateCategoryList(?array $params = null)
 *
 * @property TranslateFieldAbstractInterface[] $translatefieldlist
 * @property TranslateFieldAbstractInterface[] $TranslateFieldList
 * @method TranslateFieldAbstractInterface[] getTranslateFieldList(?array $params = null)
 *
 * @property LangAbstractInterface[] $translatefieldlanglist
 * @property LangAbstractInterface[] $TranslateFieldLangList
 * @method LangAbstractInterface[] getTranslateFieldLangList(?array $params = null)
 *
 * @property TableAbstractInterface[] $translatefieldtablelist
 * @property TableAbstractInterface[] $TranslateFieldTableList
 * @method TableAbstractInterface[] getTranslateFieldTableList(?array $params = null)
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
 *
 * @property UserAbstractInterface $restoredasentity
 * @property UserAbstractInterface $RestoredAsEntity
 * @method UserAbstractInterface getRestoredAsEntity(?array $params = null)
 */
interface SiteAbstractInterface extends ModelInterface
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
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getName(): mixed;
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void;
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Size(240) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed;
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(240) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void;
    
    /**
     * Returns the value of field icon
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @return mixed
     */
    public function getIcon(): mixed;
    
    /**
     * Sets the value of field icon
     * Column: icon 
     * Attributes: Size(64) | Type(2)
     * @param mixed $icon
     * @return void
     */
    public function setIcon(mixed $icon): void;
    
    /**
     * Returns the value of field color
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @return mixed
     */
    public function getColor(): mixed;
    
    /**
     * Sets the value of field color
     * Column: color 
     * Attributes: Size(9) | Type(5)
     * @param mixed $color
     * @return void
     */
    public function setColor(mixed $color): void;
    
    /**
     * Returns the value of field status
     * Column: status
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @return mixed
     */
    public function getStatus(): mixed;
    
    /**
     * Sets the value of field status
     * Column: status 
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @param mixed $status
     * @return void
     */
    public function setStatus(mixed $status): void;
    
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
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs(): mixed;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs(mixed $restoredAs): void;
}
