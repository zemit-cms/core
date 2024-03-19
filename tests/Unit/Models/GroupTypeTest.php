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

use Zemit\Models\Abstracts\GroupTypeAbstract;
use Zemit\Models\Abstracts\Interfaces\GroupTypeAbstractInterface;
use Zemit\Models\GroupType;
use Zemit\Models\Interfaces\GroupTypeInterface;

/**
 * Class GroupTypeTest
 *
 * This class contains unit tests for the User class.
 */
class GroupTypeTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public GroupTypeInterface $groupType;
    
    protected function setUp(): void
    {
        $this->groupType = new GroupType();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(GroupType::class, $this->groupType);
        $this->assertInstanceOf(GroupTypeInterface::class, $this->groupType);
    
        // Abstract
        $this->assertInstanceOf(GroupTypeAbstract::class, $this->groupType);
        $this->assertInstanceOf(GroupTypeAbstractInterface::class, $this->groupType);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->groupType);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->groupType);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->groupType);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->groupType);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->groupType->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->groupType->setId($value);
        $this->assertEquals($value, $this->groupType->getId());
    }

    public function testGetGroupId(): void
    {
        $this->assertEquals(null, $this->groupType->getGroupId());
    }
    
    public function testSetGroupId(): void
    {
        $value = uniqid();
        $this->groupType->setGroupId($value);
        $this->assertEquals($value, $this->groupType->getGroupId());
    }

    public function testGetTypeId(): void
    {
        $this->assertEquals(null, $this->groupType->getTypeId());
    }
    
    public function testSetTypeId(): void
    {
        $value = uniqid();
        $this->groupType->setTypeId($value);
        $this->assertEquals($value, $this->groupType->getTypeId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->groupType->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->groupType->setPosition($value);
        $this->assertEquals($value, $this->groupType->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->groupType->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->groupType->setDeleted($value);
        $this->assertEquals($value, $this->groupType->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->groupType->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->groupType->setCreatedAt($value);
        $this->assertEquals($value, $this->groupType->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->groupType->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->groupType->setCreatedBy($value);
        $this->assertEquals($value, $this->groupType->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->groupType->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->groupType->setCreatedAs($value);
        $this->assertEquals($value, $this->groupType->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->groupType->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->groupType->setUpdatedAt($value);
        $this->assertEquals($value, $this->groupType->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->groupType->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->groupType->setUpdatedBy($value);
        $this->assertEquals($value, $this->groupType->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->groupType->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->groupType->setUpdatedAs($value);
        $this->assertEquals($value, $this->groupType->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->groupType->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->groupType->setDeletedAt($value);
        $this->assertEquals($value, $this->groupType->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->groupType->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->groupType->setDeletedAs($value);
        $this->assertEquals($value, $this->groupType->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->groupType->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->groupType->setDeletedBy($value);
        $this->assertEquals($value, $this->groupType->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->groupType->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->groupType->setRestoredAt($value);
        $this->assertEquals($value, $this->groupType->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->groupType->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->groupType->setRestoredBy($value);
        $this->assertEquals($value, $this->groupType->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->groupType->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->groupType->setRestoredAs($value);
        $this->assertEquals($value, $this->groupType->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->groupType->getColumnMap());
    }
}