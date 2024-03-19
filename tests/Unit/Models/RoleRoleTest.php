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

use Zemit\Models\Abstracts\RoleRoleAbstract;
use Zemit\Models\Abstracts\Interfaces\RoleRoleAbstractInterface;
use Zemit\Models\RoleRole;
use Zemit\Models\Interfaces\RoleRoleInterface;

/**
 * Class RoleRoleTest
 *
 * This class contains unit tests for the User class.
 */
class RoleRoleTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public RoleRoleInterface $roleRole;
    
    protected function setUp(): void
    {
        $this->roleRole = new RoleRole();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(RoleRole::class, $this->roleRole);
        $this->assertInstanceOf(RoleRoleInterface::class, $this->roleRole);
    
        // Abstract
        $this->assertInstanceOf(RoleRoleAbstract::class, $this->roleRole);
        $this->assertInstanceOf(RoleRoleAbstractInterface::class, $this->roleRole);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->roleRole);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->roleRole);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->roleRole);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->roleRole);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->roleRole->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->roleRole->setId($value);
        $this->assertEquals($value, $this->roleRole->getId());
    }

    public function testGetParentId(): void
    {
        $this->assertEquals(null, $this->roleRole->getParentId());
    }
    
    public function testSetParentId(): void
    {
        $value = uniqid();
        $this->roleRole->setParentId($value);
        $this->assertEquals($value, $this->roleRole->getParentId());
    }

    public function testGetChildId(): void
    {
        $this->assertEquals(null, $this->roleRole->getChildId());
    }
    
    public function testSetChildId(): void
    {
        $value = uniqid();
        $this->roleRole->setChildId($value);
        $this->assertEquals($value, $this->roleRole->getChildId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->roleRole->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->roleRole->setPosition($value);
        $this->assertEquals($value, $this->roleRole->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->roleRole->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->roleRole->setDeleted($value);
        $this->assertEquals($value, $this->roleRole->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->roleRole->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->roleRole->setCreatedAt($value);
        $this->assertEquals($value, $this->roleRole->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->roleRole->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->roleRole->setCreatedBy($value);
        $this->assertEquals($value, $this->roleRole->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->roleRole->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->roleRole->setCreatedAs($value);
        $this->assertEquals($value, $this->roleRole->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->roleRole->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->roleRole->setUpdatedAt($value);
        $this->assertEquals($value, $this->roleRole->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->roleRole->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->roleRole->setUpdatedBy($value);
        $this->assertEquals($value, $this->roleRole->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->roleRole->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->roleRole->setUpdatedAs($value);
        $this->assertEquals($value, $this->roleRole->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->roleRole->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->roleRole->setDeletedAt($value);
        $this->assertEquals($value, $this->roleRole->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->roleRole->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->roleRole->setDeletedAs($value);
        $this->assertEquals($value, $this->roleRole->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->roleRole->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->roleRole->setDeletedBy($value);
        $this->assertEquals($value, $this->roleRole->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->roleRole->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->roleRole->setRestoredAt($value);
        $this->assertEquals($value, $this->roleRole->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->roleRole->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->roleRole->setRestoredBy($value);
        $this->assertEquals($value, $this->roleRole->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->roleRole->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->roleRole->setRestoredAs($value);
        $this->assertEquals($value, $this->roleRole->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->roleRole->getColumnMap());
    }
}