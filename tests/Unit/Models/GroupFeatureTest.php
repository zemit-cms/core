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

use Zemit\Models\Abstracts\GroupFeatureAbstract;
use Zemit\Models\Abstracts\Interfaces\GroupFeatureAbstractInterface;
use Zemit\Models\GroupFeature;
use Zemit\Models\Interfaces\GroupFeatureInterface;

/**
 * Class GroupFeatureTest
 *
 * This class contains unit tests for the User class.
 */
class GroupFeatureTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public GroupFeatureInterface $groupFeature;
    
    protected function setUp(): void
    {
        $this->groupFeature = new GroupFeature();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(GroupFeature::class, $this->groupFeature);
        $this->assertInstanceOf(GroupFeatureInterface::class, $this->groupFeature);
    
        // Abstract
        $this->assertInstanceOf(GroupFeatureAbstract::class, $this->groupFeature);
        $this->assertInstanceOf(GroupFeatureAbstractInterface::class, $this->groupFeature);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->groupFeature);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->groupFeature);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->groupFeature);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->groupFeature);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->groupFeature->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->groupFeature->setId($value);
        $this->assertEquals($value, $this->groupFeature->getId());
    }

    public function testGetGroupId(): void
    {
        $this->assertEquals(null, $this->groupFeature->getGroupId());
    }
    
    public function testSetGroupId(): void
    {
        $value = uniqid();
        $this->groupFeature->setGroupId($value);
        $this->assertEquals($value, $this->groupFeature->getGroupId());
    }

    public function testGetFeatureId(): void
    {
        $this->assertEquals(null, $this->groupFeature->getFeatureId());
    }
    
    public function testSetFeatureId(): void
    {
        $value = uniqid();
        $this->groupFeature->setFeatureId($value);
        $this->assertEquals($value, $this->groupFeature->getFeatureId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->groupFeature->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->groupFeature->setPosition($value);
        $this->assertEquals($value, $this->groupFeature->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->groupFeature->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->groupFeature->setDeleted($value);
        $this->assertEquals($value, $this->groupFeature->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->groupFeature->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->groupFeature->setCreatedAt($value);
        $this->assertEquals($value, $this->groupFeature->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->groupFeature->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->groupFeature->setCreatedBy($value);
        $this->assertEquals($value, $this->groupFeature->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->groupFeature->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->groupFeature->setCreatedAs($value);
        $this->assertEquals($value, $this->groupFeature->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->groupFeature->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->groupFeature->setUpdatedAt($value);
        $this->assertEquals($value, $this->groupFeature->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->groupFeature->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->groupFeature->setUpdatedBy($value);
        $this->assertEquals($value, $this->groupFeature->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->groupFeature->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->groupFeature->setUpdatedAs($value);
        $this->assertEquals($value, $this->groupFeature->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->groupFeature->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->groupFeature->setDeletedAt($value);
        $this->assertEquals($value, $this->groupFeature->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->groupFeature->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->groupFeature->setDeletedAs($value);
        $this->assertEquals($value, $this->groupFeature->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->groupFeature->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->groupFeature->setDeletedBy($value);
        $this->assertEquals($value, $this->groupFeature->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->groupFeature->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->groupFeature->setRestoredAt($value);
        $this->assertEquals($value, $this->groupFeature->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->groupFeature->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->groupFeature->setRestoredBy($value);
        $this->assertEquals($value, $this->groupFeature->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->groupFeature->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->groupFeature->setRestoredAs($value);
        $this->assertEquals($value, $this->groupFeature->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->groupFeature->getColumnMap());
    }
}