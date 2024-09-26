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

use Zemit\Models\Abstracts\UserRoleAbstract;
use Zemit\Models\Abstracts\Interfaces\UserRoleAbstractInterface;
use Zemit\Models\UserRole;
use Zemit\Models\Interfaces\UserRoleInterface;

/**
 * Class UserRoleTest
 *
 * This class contains unit tests for the User class.
 */
class UserRoleTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public UserRoleInterface $userRole;
    
    protected function setUp(): void
    {
        $this->userRole = new UserRole();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(UserRole::class, $this->userRole);
        $this->assertInstanceOf(UserRoleInterface::class, $this->userRole);
    
        // Abstract
        $this->assertInstanceOf(UserRoleAbstract::class, $this->userRole);
        $this->assertInstanceOf(UserRoleAbstractInterface::class, $this->userRole);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->userRole);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->userRole);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->userRole);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->userRole);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->userRole->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->userRole->setId($value);
        $this->assertEquals($value, $this->userRole->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->userRole->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->userRole->setUserId($value);
        $this->assertEquals($value, $this->userRole->getUserId());
    }

    public function testGetRoleId(): void
    {
        $this->assertEquals(null, $this->userRole->getRoleId());
    }
    
    public function testSetRoleId(): void
    {
        $value = uniqid();
        $this->userRole->setRoleId($value);
        $this->assertEquals($value, $this->userRole->getRoleId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->userRole->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->userRole->setPosition($value);
        $this->assertEquals($value, $this->userRole->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->userRole->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->userRole->setDeleted($value);
        $this->assertEquals($value, $this->userRole->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->userRole->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->userRole->setCreatedAt($value);
        $this->assertEquals($value, $this->userRole->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->userRole->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->userRole->setCreatedBy($value);
        $this->assertEquals($value, $this->userRole->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->userRole->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->userRole->setCreatedAs($value);
        $this->assertEquals($value, $this->userRole->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->userRole->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->userRole->setUpdatedAt($value);
        $this->assertEquals($value, $this->userRole->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->userRole->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->userRole->setUpdatedBy($value);
        $this->assertEquals($value, $this->userRole->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->userRole->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->userRole->setUpdatedAs($value);
        $this->assertEquals($value, $this->userRole->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->userRole->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->userRole->setDeletedAt($value);
        $this->assertEquals($value, $this->userRole->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->userRole->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->userRole->setDeletedAs($value);
        $this->assertEquals($value, $this->userRole->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->userRole->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->userRole->setDeletedBy($value);
        $this->assertEquals($value, $this->userRole->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->userRole->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->userRole->setRestoredAt($value);
        $this->assertEquals($value, $this->userRole->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->userRole->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->userRole->setRestoredBy($value);
        $this->assertEquals($value, $this->userRole->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->userRole->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->userRole->setRestoredAs($value);
        $this->assertEquals($value, $this->userRole->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->userRole->getColumnMap());
    }
}
