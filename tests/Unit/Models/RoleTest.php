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

use Zemit\Models\Abstracts\RoleAbstract;
use Zemit\Models\Abstracts\Interfaces\RoleAbstractInterface;
use Zemit\Models\Role;
use Zemit\Models\Interfaces\RoleInterface;

/**
 * Class RoleTest
 *
 * This class contains unit tests for the User class.
 */
class RoleTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public RoleInterface $role;
    
    protected function setUp(): void
    {
        $this->role = new Role();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleInterface::class, $this->role);
    
        // Abstract
        $this->assertInstanceOf(RoleAbstract::class, $this->role);
        $this->assertInstanceOf(RoleAbstractInterface::class, $this->role);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->role);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->role);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->role);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->role);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->role->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->role->setId($value);
        $this->assertEquals($value, $this->role->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->role->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->role->setIndex($value);
        $this->assertEquals($value, $this->role->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->role->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->role->setLabel($value);
        $this->assertEquals($value, $this->role->getLabel());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->role->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->role->setPosition($value);
        $this->assertEquals($value, $this->role->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->role->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->role->setDeleted($value);
        $this->assertEquals($value, $this->role->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->role->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->role->setCreatedAt($value);
        $this->assertEquals($value, $this->role->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->role->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->role->setCreatedBy($value);
        $this->assertEquals($value, $this->role->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->role->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->role->setCreatedAs($value);
        $this->assertEquals($value, $this->role->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->role->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->role->setUpdatedAt($value);
        $this->assertEquals($value, $this->role->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->role->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->role->setUpdatedBy($value);
        $this->assertEquals($value, $this->role->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->role->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->role->setUpdatedAs($value);
        $this->assertEquals($value, $this->role->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->role->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->role->setDeletedAt($value);
        $this->assertEquals($value, $this->role->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->role->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->role->setDeletedAs($value);
        $this->assertEquals($value, $this->role->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->role->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->role->setDeletedBy($value);
        $this->assertEquals($value, $this->role->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->role->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->role->setRestoredAt($value);
        $this->assertEquals($value, $this->role->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->role->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->role->setRestoredBy($value);
        $this->assertEquals($value, $this->role->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->role->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->role->setRestoredAs($value);
        $this->assertEquals($value, $this->role->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->role->getColumnMap());
    }
}