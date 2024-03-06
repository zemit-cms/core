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

interface FileAbstractInterface extends ModelInterface
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
     * Returns the value of field userId
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUserId();
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $userId
     * @return void
     */
    public function setUserId($userId);
    
    /**
     * Returns the value of field category
     * Column: category
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @return mixed
     */
    public function getCategory();
    
    /**
     * Sets the value of field category
     * Column: category 
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @param mixed $category
     * @return void
     */
    public function setCategory($category);
    
    /**
     * Returns the value of field key
     * Column: key
     * Attributes: Size(50) | Type(2)
     * @return mixed
     */
    public function getKey();
    
    /**
     * Sets the value of field key
     * Column: key 
     * Attributes: Size(50) | Type(2)
     * @param mixed $key
     * @return void
     */
    public function setKey($key);
    
    /**
     * Returns the value of field path
     * Column: path
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getPath();
    
    /**
     * Sets the value of field path
     * Column: path 
     * Attributes: Size(120) | Type(2)
     * @param mixed $path
     * @return void
     */
    public function setPath($path);
    
    /**
     * Returns the value of field type
     * Column: type
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getType();
    
    /**
     * Sets the value of field type
     * Column: type 
     * Attributes: Size(100) | Type(2)
     * @param mixed $type
     * @return void
     */
    public function setType($type);
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getTypeReal();
    
    /**
     * Sets the value of field typeReal
     * Column: type_real 
     * Attributes: Size(100) | Type(2)
     * @param mixed $typeReal
     * @return void
     */
    public function setTypeReal($typeReal);
    
    /**
     * Returns the value of field extension
     * Column: extension
     * Attributes: Size(6) | Type(5)
     * @return mixed
     */
    public function getExtension();
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * Attributes: Size(6) | Type(5)
     * @param mixed $extension
     * @return void
     */
    public function setExtension($extension);
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getName();
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: Size(100) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName($name);
    
    /**
     * Returns the value of field nameTemp
     * Column: name_temp
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getNameTemp();
    
    /**
     * Sets the value of field nameTemp
     * Column: name_temp 
     * Attributes: Size(120) | Type(2)
     * @param mixed $nameTemp
     * @return void
     */
    public function setNameTemp($nameTemp);
    
    /**
     * Returns the value of field size
     * Column: size
     * Attributes: Size(45) | Type(2)
     * @return mixed
     */
    public function getSize();
    
    /**
     * Sets the value of field size
     * Column: size 
     * Attributes: Size(45) | Type(2)
     * @param mixed $size
     * @return void
     */
    public function setSize($size);
    
    /**
     * Returns the value of field error
     * Column: error
     * Attributes: Type(6)
     * @return mixed
     */
    public function getError();
    
    /**
     * Sets the value of field error
     * Column: error 
     * Attributes: Type(6)
     * @param mixed $error
     * @return void
     */
    public function setError($error);
    
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