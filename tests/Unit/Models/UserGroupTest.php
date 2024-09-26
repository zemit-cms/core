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

use Zemit\Models\Abstracts\UserGroupAbstract;
use Zemit\Models\Abstracts\Interfaces\UserGroupAbstractInterface;
use Zemit\Models\UserGroup;
use Zemit\Models\Interfaces\UserGroupInterface;

/**
 * Class UserGroupTest
 *
 * This class contains unit tests for the User class.
 */
class UserGroupTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public UserGroupInterface $userGroup;
    
    protected function setUp(): void
    {
        $this->userGroup = new UserGroup();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(UserGroup::class, $this->userGroup);
        $this->assertInstanceOf(UserGroupInterface::class, $this->userGroup);
    
        // Abstract
        $this->assertInstanceOf(UserGroupAbstract::class, $this->userGroup);
        $this->assertInstanceOf(UserGroupAbstractInterface::class, $this->userGroup);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->userGroup);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->userGroup);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->userGroup);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->userGroup);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->userGroup->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->userGroup->setId($value);
        $this->assertEquals($value, $this->userGroup->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->userGroup->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->userGroup->setUserId($value);
        $this->assertEquals($value, $this->userGroup->getUserId());
    }

    public function testGetGroupId(): void
    {
        $this->assertEquals(null, $this->userGroup->getGroupId());
    }
    
    public function testSetGroupId(): void
    {
        $value = uniqid();
        $this->userGroup->setGroupId($value);
        $this->assertEquals($value, $this->userGroup->getGroupId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->userGroup->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->userGroup->setPosition($value);
        $this->assertEquals($value, $this->userGroup->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->userGroup->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->userGroup->setDeleted($value);
        $this->assertEquals($value, $this->userGroup->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->userGroup->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->userGroup->setCreatedAt($value);
        $this->assertEquals($value, $this->userGroup->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->userGroup->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->userGroup->setCreatedBy($value);
        $this->assertEquals($value, $this->userGroup->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->userGroup->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->userGroup->setCreatedAs($value);
        $this->assertEquals($value, $this->userGroup->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->userGroup->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->userGroup->setUpdatedAt($value);
        $this->assertEquals($value, $this->userGroup->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->userGroup->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->userGroup->setUpdatedBy($value);
        $this->assertEquals($value, $this->userGroup->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->userGroup->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->userGroup->setUpdatedAs($value);
        $this->assertEquals($value, $this->userGroup->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->userGroup->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->userGroup->setDeletedAt($value);
        $this->assertEquals($value, $this->userGroup->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->userGroup->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->userGroup->setDeletedAs($value);
        $this->assertEquals($value, $this->userGroup->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->userGroup->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->userGroup->setDeletedBy($value);
        $this->assertEquals($value, $this->userGroup->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->userGroup->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->userGroup->setRestoredAt($value);
        $this->assertEquals($value, $this->userGroup->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->userGroup->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->userGroup->setRestoredBy($value);
        $this->assertEquals($value, $this->userGroup->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->userGroup->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->userGroup->setRestoredAs($value);
        $this->assertEquals($value, $this->userGroup->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->userGroup->getColumnMap());
    }
}
