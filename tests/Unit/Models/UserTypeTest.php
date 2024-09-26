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

namespace Zemit\Tests\Unit\Models;

use Zemit\Models\Abstracts\UserTypeAbstract;
use Zemit\Models\Abstracts\Interfaces\UserTypeAbstractInterface;
use Zemit\Models\UserType;
use Zemit\Models\Interfaces\UserTypeInterface;

/**
 * Class UserTypeTest
 *
 * This class contains unit tests for the User class.
 */
class UserTypeTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public UserTypeInterface $userType;
    
    protected function setUp(): void
    {
        $this->userType = new UserType();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(UserType::class, $this->userType);
        $this->assertInstanceOf(UserTypeInterface::class, $this->userType);
    
        // Abstract
        $this->assertInstanceOf(UserTypeAbstract::class, $this->userType);
        $this->assertInstanceOf(UserTypeAbstractInterface::class, $this->userType);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->userType);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->userType);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->userType);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->userType);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->userType->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->userType->setId($value);
        $this->assertEquals($value, $this->userType->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->userType->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->userType->setUserId($value);
        $this->assertEquals($value, $this->userType->getUserId());
    }

    public function testGetTypeId(): void
    {
        $this->assertEquals(null, $this->userType->getTypeId());
    }
    
    public function testSetTypeId(): void
    {
        $value = uniqid();
        $this->userType->setTypeId($value);
        $this->assertEquals($value, $this->userType->getTypeId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->userType->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->userType->setPosition($value);
        $this->assertEquals($value, $this->userType->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->userType->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->userType->setDeleted($value);
        $this->assertEquals($value, $this->userType->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->userType->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->userType->setCreatedAt($value);
        $this->assertEquals($value, $this->userType->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->userType->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->userType->setCreatedBy($value);
        $this->assertEquals($value, $this->userType->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->userType->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->userType->setCreatedAs($value);
        $this->assertEquals($value, $this->userType->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->userType->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->userType->setUpdatedAt($value);
        $this->assertEquals($value, $this->userType->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->userType->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->userType->setUpdatedBy($value);
        $this->assertEquals($value, $this->userType->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->userType->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->userType->setUpdatedAs($value);
        $this->assertEquals($value, $this->userType->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->userType->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->userType->setDeletedAt($value);
        $this->assertEquals($value, $this->userType->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->userType->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->userType->setDeletedAs($value);
        $this->assertEquals($value, $this->userType->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->userType->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->userType->setDeletedBy($value);
        $this->assertEquals($value, $this->userType->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->userType->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->userType->setRestoredAt($value);
        $this->assertEquals($value, $this->userType->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->userType->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->userType->setRestoredBy($value);
        $this->assertEquals($value, $this->userType->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->userType->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->userType->setRestoredAs($value);
        $this->assertEquals($value, $this->userType->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->userType->getColumnMap());
    }
}
