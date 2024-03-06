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

interface Oauth2AbstractInterface extends ModelInterface
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
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getUserId();
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $userId
     * @return void
     */
    public function setUserId($userId);
    
    /**
     * Returns the value of field provider
     * Column: provider
     * Attributes: NotNull | Size('google','microsoft') | Type(18)
     * @return mixed
     */
    public function getProvider();
    
    /**
     * Sets the value of field provider
     * Column: provider 
     * Attributes: NotNull | Size('google','microsoft') | Type(18)
     * @param mixed $provider
     * @return void
     */
    public function setProvider($provider);
    
    /**
     * Returns the value of field providerUuid
     * Column: provider_uuid
     * Attributes: NotNull | Size(120) | Type(2)
     * @return mixed
     */
    public function getProviderUuid();
    
    /**
     * Sets the value of field providerUuid
     * Column: provider_uuid 
     * Attributes: NotNull | Size(120) | Type(2)
     * @param mixed $providerUuid
     * @return void
     */
    public function setProviderUuid($providerUuid);
    
    /**
     * Returns the value of field accessToken
     * Column: access_token
     * Attributes: NotNull | Size(120) | Type(2)
     * @return mixed
     */
    public function getAccessToken();
    
    /**
     * Sets the value of field accessToken
     * Column: access_token 
     * Attributes: NotNull | Size(120) | Type(2)
     * @param mixed $accessToken
     * @return void
     */
    public function setAccessToken($accessToken);
    
    /**
     * Returns the value of field refreshToken
     * Column: refresh_token
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getRefreshToken();
    
    /**
     * Sets the value of field refreshToken
     * Column: refresh_token 
     * Attributes: Size(120) | Type(2)
     * @param mixed $refreshToken
     * @return void
     */
    public function setRefreshToken($refreshToken);
    
    /**
     * Returns the value of field email
     * Column: email
     * Attributes: Size(320) | Type(2)
     * @return mixed
     */
    public function getEmail();
    
    /**
     * Sets the value of field email
     * Column: email 
     * Attributes: Size(320) | Type(2)
     * @param mixed $email
     * @return void
     */
    public function setEmail($email);
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getName();
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: Size(120) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName($name);
    
    /**
     * Returns the value of field firstName
     * Column: first_name
     * Attributes: Size(60) | Type(2)
     * @return mixed
     */
    public function getFirstName();
    
    /**
     * Sets the value of field firstName
     * Column: first_name 
     * Attributes: Size(60) | Type(2)
     * @param mixed $firstName
     * @return void
     */
    public function setFirstName($firstName);
    
    /**
     * Returns the value of field lastName
     * Column: last_name
     * Attributes: Size(60) | Type(2)
     * @return mixed
     */
    public function getLastName();
    
    /**
     * Sets the value of field lastName
     * Column: last_name 
     * Attributes: Size(60) | Type(2)
     * @param mixed $lastName
     * @return void
     */
    public function setLastName($lastName);
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(15)
     * @return mixed
     */
    public function getMeta();
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(15)
     * @param mixed $meta
     * @return void
     */
    public function setMeta($meta);
    
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
}