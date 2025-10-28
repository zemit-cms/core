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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->groupFeature->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->groupFeature->setUuid($value);
        $this->assertEquals($value, $this->groupFeature->getUuid());
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
        $this->assertEquals('current_timestamp()', $this->groupFeature->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->groupFeature->getColumnMap());
    }
}
