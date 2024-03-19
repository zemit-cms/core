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

use Zemit\Models\Abstracts\GroupRoleAbstract;
use Zemit\Models\Abstracts\Interfaces\GroupRoleAbstractInterface;
use Zemit\Models\GroupRole;
use Zemit\Models\Interfaces\GroupRoleInterface;

/**
 * Class GroupRoleTest
 *
 * This class contains unit tests for the User class.
 */
class GroupRoleTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public GroupRoleInterface $groupRole;
    
    protected function setUp(): void
    {
        $this->groupRole = new GroupRole();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(GroupRole::class, $this->groupRole);
        $this->assertInstanceOf(GroupRoleInterface::class, $this->groupRole);
    
        // Abstract
        $this->assertInstanceOf(GroupRoleAbstract::class, $this->groupRole);
        $this->assertInstanceOf(GroupRoleAbstractInterface::class, $this->groupRole);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->groupRole);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->groupRole);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->groupRole);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->groupRole);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->groupRole->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->groupRole->setId($value);
        $this->assertEquals($value, $this->groupRole->getId());
    }

    public function testGetGroupId(): void
    {
        $this->assertEquals(null, $this->groupRole->getGroupId());
    }
    
    public function testSetGroupId(): void
    {
        $value = uniqid();
        $this->groupRole->setGroupId($value);
        $this->assertEquals($value, $this->groupRole->getGroupId());
    }

    public function testGetRoleId(): void
    {
        $this->assertEquals(null, $this->groupRole->getRoleId());
    }
    
    public function testSetRoleId(): void
    {
        $value = uniqid();
        $this->groupRole->setRoleId($value);
        $this->assertEquals($value, $this->groupRole->getRoleId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->groupRole->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->groupRole->setPosition($value);
        $this->assertEquals($value, $this->groupRole->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->groupRole->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->groupRole->setDeleted($value);
        $this->assertEquals($value, $this->groupRole->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->groupRole->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->groupRole->setCreatedAt($value);
        $this->assertEquals($value, $this->groupRole->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->groupRole->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->groupRole->setCreatedBy($value);
        $this->assertEquals($value, $this->groupRole->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->groupRole->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->groupRole->setCreatedAs($value);
        $this->assertEquals($value, $this->groupRole->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->groupRole->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->groupRole->setUpdatedAt($value);
        $this->assertEquals($value, $this->groupRole->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->groupRole->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->groupRole->setUpdatedBy($value);
        $this->assertEquals($value, $this->groupRole->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->groupRole->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->groupRole->setUpdatedAs($value);
        $this->assertEquals($value, $this->groupRole->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->groupRole->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->groupRole->setDeletedAt($value);
        $this->assertEquals($value, $this->groupRole->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->groupRole->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->groupRole->setDeletedAs($value);
        $this->assertEquals($value, $this->groupRole->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->groupRole->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->groupRole->setDeletedBy($value);
        $this->assertEquals($value, $this->groupRole->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->groupRole->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->groupRole->setRestoredAt($value);
        $this->assertEquals($value, $this->groupRole->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->groupRole->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->groupRole->setRestoredBy($value);
        $this->assertEquals($value, $this->groupRole->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->groupRole->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->groupRole->setRestoredAs($value);
        $this->assertEquals($value, $this->groupRole->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->groupRole->getColumnMap());
    }
}