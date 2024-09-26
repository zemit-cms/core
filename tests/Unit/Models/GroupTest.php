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

use Zemit\Models\Abstracts\GroupAbstract;
use Zemit\Models\Abstracts\Interfaces\GroupAbstractInterface;
use Zemit\Models\Group;
use Zemit\Models\Interfaces\GroupInterface;

/**
 * Class GroupTest
 *
 * This class contains unit tests for the User class.
 */
class GroupTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public GroupInterface $group;
    
    protected function setUp(): void
    {
        $this->group = new Group();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Group::class, $this->group);
        $this->assertInstanceOf(GroupInterface::class, $this->group);
    
        // Abstract
        $this->assertInstanceOf(GroupAbstract::class, $this->group);
        $this->assertInstanceOf(GroupAbstractInterface::class, $this->group);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->group);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->group);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->group);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->group);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->group->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->group->setId($value);
        $this->assertEquals($value, $this->group->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->group->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->group->setIndex($value);
        $this->assertEquals($value, $this->group->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->group->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->group->setLabel($value);
        $this->assertEquals($value, $this->group->getLabel());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->group->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->group->setPosition($value);
        $this->assertEquals($value, $this->group->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->group->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->group->setDeleted($value);
        $this->assertEquals($value, $this->group->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->group->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->group->setCreatedAt($value);
        $this->assertEquals($value, $this->group->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->group->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->group->setCreatedBy($value);
        $this->assertEquals($value, $this->group->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->group->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->group->setCreatedAs($value);
        $this->assertEquals($value, $this->group->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->group->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->group->setUpdatedAt($value);
        $this->assertEquals($value, $this->group->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->group->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->group->setUpdatedBy($value);
        $this->assertEquals($value, $this->group->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->group->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->group->setUpdatedAs($value);
        $this->assertEquals($value, $this->group->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->group->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->group->setDeletedAt($value);
        $this->assertEquals($value, $this->group->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->group->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->group->setDeletedAs($value);
        $this->assertEquals($value, $this->group->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->group->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->group->setDeletedBy($value);
        $this->assertEquals($value, $this->group->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->group->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->group->setRestoredAt($value);
        $this->assertEquals($value, $this->group->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->group->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->group->setRestoredBy($value);
        $this->assertEquals($value, $this->group->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->group->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->group->setRestoredAs($value);
        $this->assertEquals($value, $this->group->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->group->getColumnMap());
    }
}
