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
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $CategoryLangList
 * @method LangAbstractInterface[] getCategoryLangList(?array $params = null)
 *
 * @property DataAbstractInterface[] $datalist
 * @property DataAbstractInterface[] $DataList
 * @method DataAbstractInterface[] getDataList(?array $params = null)
 *
 * @property TableAbstractInterface[] $tablelist
 * @property TableAbstractInterface[] $DataTableList
 * @method TableAbstractInterface[] getDataTableList(?array $params = null)
 *
 * @property FieldAbstractInterface[] $fieldlist
 * @property FieldAbstractInterface[] $DataFieldList
 * @method FieldAbstractInterface[] getDataFieldList(?array $params = null)
 *
 * @property FieldAbstractInterface[] $fieldlist
 * @property FieldAbstractInterface[] $FieldList
 * @method FieldAbstractInterface[] getFieldList(?array $params = null)
 *
 * @property TableAbstractInterface[] $tablelist
 * @property TableAbstractInterface[] $FieldTableList
 * @method TableAbstractInterface[] getFieldTableList(?array $params = null)
 *
 * @property FlagAbstractInterface[] $flaglist
 * @property FlagAbstractInterface[] $FlagList
 * @method FlagAbstractInterface[] getFlagList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
 * @property PageAbstractInterface[] $FlagPageList
 * @method PageAbstractInterface[] getFlagPageList(?array $params = null)
 *
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $FlagLangList
 * @method LangAbstractInterface[] getFlagLangList(?array $params = null)
 *
 * @property MetaAbstractInterface[] $metalist
 * @property MetaAbstractInterface[] $MetaList
 * @method MetaAbstractInterface[] getMetaList(?array $params = null)
 *
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $MetaLangList
 * @method LangAbstractInterface[] getMetaLangList(?array $params = null)
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
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $PageLangList
 * @method LangAbstractInterface[] getPageLangList(?array $params = null)
 *
 * @property PostAbstractInterface[] $postlist
 * @property PostAbstractInterface[] $PostList
 * @method PostAbstractInterface[] getPostList(?array $params = null)
 *
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $PostLangList
 * @method LangAbstractInterface[] getPostLangList(?array $params = null)
 *
 * @property PageAbstractInterface[] $pagelist
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
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $TranslateLangList
 * @method LangAbstractInterface[] getTranslateLangList(?array $params = null)
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
 * @property LangAbstractInterface[] $langlist
 * @property LangAbstractInterface[] $TranslateFieldLangList
 * @method LangAbstractInterface[] getTranslateFieldLangList(?array $params = null)
 *
 * @property TableAbstractInterface[] $tablelist
 * @property TableAbstractInterface[] $TranslateFieldTableList
 * @method TableAbstractInterface[] getTranslateFieldTableList(?array $params = null)
 */
interface SiteAbstractInterface extends ModelInterface
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
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getName();
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName($name);
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Size(240) | Type(2)
     * @return mixed
     */
    public function getDescription();
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(240) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription($description);
    
    /**
     * Returns the value of field icon
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @return mixed
     */
    public function getIcon();
    
    /**
     * Sets the value of field icon
     * Column: icon 
     * Attributes: Size(64) | Type(2)
     * @param mixed $icon
     * @return void
     */
    public function setIcon($icon);
    
    /**
     * Returns the value of field color
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @return mixed
     */
    public function getColor();
    
    /**
     * Sets the value of field color
     * Column: color 
     * Attributes: Size(9) | Type(5)
     * @param mixed $color
     * @return void
     */
    public function setColor($color);
    
    /**
     * Returns the value of field status
     * Column: status
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @return mixed
     */
    public function getStatus();
    
    /**
     * Sets the value of field status
     * Column: status 
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @param mixed $status
     * @return void
     */
    public function setStatus($status);
    
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