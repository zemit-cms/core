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

use Zemit\Models\Abstracts\UserFeatureAbstract;
use Zemit\Models\Abstracts\Interfaces\UserFeatureAbstractInterface;
use Zemit\Models\UserFeature;
use Zemit\Models\Interfaces\UserFeatureInterface;

/**
 * Class UserFeatureTest
 *
 * This class contains unit tests for the User class.
 */
class UserFeatureTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public UserFeatureInterface $userFeature;
    
    protected function setUp(): void
    {
        $this->userFeature = new UserFeature();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(UserFeature::class, $this->userFeature);
        $this->assertInstanceOf(UserFeatureInterface::class, $this->userFeature);
    
        // Abstract
        $this->assertInstanceOf(UserFeatureAbstract::class, $this->userFeature);
        $this->assertInstanceOf(UserFeatureAbstractInterface::class, $this->userFeature);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->userFeature);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->userFeature);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->userFeature);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->userFeature);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->userFeature->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->userFeature->setId($value);
        $this->assertEquals($value, $this->userFeature->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->userFeature->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->userFeature->setUserId($value);
        $this->assertEquals($value, $this->userFeature->getUserId());
    }

    public function testGetFeatureId(): void
    {
        $this->assertEquals(null, $this->userFeature->getFeatureId());
    }
    
    public function testSetFeatureId(): void
    {
        $value = uniqid();
        $this->userFeature->setFeatureId($value);
        $this->assertEquals($value, $this->userFeature->getFeatureId());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->userFeature->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->userFeature->setPosition($value);
        $this->assertEquals($value, $this->userFeature->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->userFeature->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->userFeature->setDeleted($value);
        $this->assertEquals($value, $this->userFeature->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->userFeature->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->userFeature->setCreatedAt($value);
        $this->assertEquals($value, $this->userFeature->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->userFeature->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->userFeature->setCreatedBy($value);
        $this->assertEquals($value, $this->userFeature->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->userFeature->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->userFeature->setCreatedAs($value);
        $this->assertEquals($value, $this->userFeature->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->userFeature->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->userFeature->setUpdatedAt($value);
        $this->assertEquals($value, $this->userFeature->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->userFeature->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->userFeature->setUpdatedBy($value);
        $this->assertEquals($value, $this->userFeature->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->userFeature->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->userFeature->setUpdatedAs($value);
        $this->assertEquals($value, $this->userFeature->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->userFeature->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->userFeature->setDeletedAt($value);
        $this->assertEquals($value, $this->userFeature->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->userFeature->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->userFeature->setDeletedAs($value);
        $this->assertEquals($value, $this->userFeature->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->userFeature->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->userFeature->setDeletedBy($value);
        $this->assertEquals($value, $this->userFeature->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->userFeature->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->userFeature->setRestoredAt($value);
        $this->assertEquals($value, $this->userFeature->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->userFeature->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->userFeature->setRestoredBy($value);
        $this->assertEquals($value, $this->userFeature->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->userFeature->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->userFeature->setRestoredAs($value);
        $this->assertEquals($value, $this->userFeature->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->userFeature->getColumnMap());
    }
}
