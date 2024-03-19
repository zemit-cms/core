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

use Zemit\Models\Abstracts\RoleFeatureAbstract;
use Zemit\Models\Abstracts\Interfaces\RoleFeatureAbstractInterface;
use Zemit\Models\RoleFeature;
use Zemit\Models\Interfaces\RoleFeatureInterface;

/**
 * Class RoleFeatureTest
 *
 * This class contains unit tests for the User class.
 */
class RoleFeatureTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public RoleFeatureInterface $roleFeature;
    
    protected function setUp(): void
    {
        $this->roleFeature = new RoleFeature();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(RoleFeature::class, $this->roleFeature);
        $this->assertInstanceOf(RoleFeatureInterface::class, $this->roleFeature);
    
        // Abstract
        $this->assertInstanceOf(RoleFeatureAbstract::class, $this->roleFeature);
        $this->assertInstanceOf(RoleFeatureAbstractInterface::class, $this->roleFeature);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->roleFeature);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->roleFeature);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->roleFeature);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->roleFeature);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->roleFeature->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->roleFeature->setId($value);
        $this->assertEquals($value, $this->roleFeature->getId());
    }

    public function testGetRoleId(): void
    {
        $this->assertEquals(null, $this->roleFeature->getRoleId());
    }
    
    public function testSetRoleId(): void
    {
        $value = uniqid();
        $this->roleFeature->setRoleId($value);
        $this->assertEquals($value, $this->roleFeature->getRoleId());
    }

    public function testGetFeatureId(): void
    {
        $this->assertEquals(null, $this->roleFeature->getFeatureId());
    }
    
    public function testSetFeatureId(): void
    {
        $value = uniqid();
        $this->roleFeature->setFeatureId($value);
        $this->assertEquals($value, $this->roleFeature->getFeatureId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->roleFeature->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->roleFeature->setPosition($value);
        $this->assertEquals($value, $this->roleFeature->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->roleFeature->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->roleFeature->setDeleted($value);
        $this->assertEquals($value, $this->roleFeature->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->roleFeature->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->roleFeature->setCreatedAt($value);
        $this->assertEquals($value, $this->roleFeature->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->roleFeature->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->roleFeature->setCreatedBy($value);
        $this->assertEquals($value, $this->roleFeature->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->roleFeature->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->roleFeature->setCreatedAs($value);
        $this->assertEquals($value, $this->roleFeature->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->roleFeature->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->roleFeature->setUpdatedAt($value);
        $this->assertEquals($value, $this->roleFeature->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->roleFeature->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->roleFeature->setUpdatedBy($value);
        $this->assertEquals($value, $this->roleFeature->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->roleFeature->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->roleFeature->setUpdatedAs($value);
        $this->assertEquals($value, $this->roleFeature->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->roleFeature->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->roleFeature->setDeletedAt($value);
        $this->assertEquals($value, $this->roleFeature->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->roleFeature->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->roleFeature->setDeletedAs($value);
        $this->assertEquals($value, $this->roleFeature->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->roleFeature->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->roleFeature->setDeletedBy($value);
        $this->assertEquals($value, $this->roleFeature->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->roleFeature->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->roleFeature->setRestoredAt($value);
        $this->assertEquals($value, $this->roleFeature->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->roleFeature->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->roleFeature->setRestoredBy($value);
        $this->assertEquals($value, $this->roleFeature->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->roleFeature->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->roleFeature->setRestoredAs($value);
        $this->assertEquals($value, $this->roleFeature->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->roleFeature->getColumnMap());
    }
}