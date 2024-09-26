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

use Zemit\Models\Abstracts\FeatureAbstract;
use Zemit\Models\Abstracts\Interfaces\FeatureAbstractInterface;
use Zemit\Models\Feature;
use Zemit\Models\Interfaces\FeatureInterface;

/**
 * Class FeatureTest
 *
 * This class contains unit tests for the User class.
 */
class FeatureTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public FeatureInterface $feature;
    
    protected function setUp(): void
    {
        $this->feature = new Feature();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Feature::class, $this->feature);
        $this->assertInstanceOf(FeatureInterface::class, $this->feature);
    
        // Abstract
        $this->assertInstanceOf(FeatureAbstract::class, $this->feature);
        $this->assertInstanceOf(FeatureAbstractInterface::class, $this->feature);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->feature);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->feature);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->feature);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->feature);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->feature->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->feature->setId($value);
        $this->assertEquals($value, $this->feature->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->feature->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->feature->setIndex($value);
        $this->assertEquals($value, $this->feature->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->feature->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->feature->setLabel($value);
        $this->assertEquals($value, $this->feature->getLabel());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->feature->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->feature->setPosition($value);
        $this->assertEquals($value, $this->feature->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->feature->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->feature->setDeleted($value);
        $this->assertEquals($value, $this->feature->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->feature->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->feature->setCreatedAt($value);
        $this->assertEquals($value, $this->feature->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->feature->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->feature->setCreatedBy($value);
        $this->assertEquals($value, $this->feature->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->feature->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->feature->setCreatedAs($value);
        $this->assertEquals($value, $this->feature->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->feature->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->feature->setUpdatedAt($value);
        $this->assertEquals($value, $this->feature->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->feature->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->feature->setUpdatedBy($value);
        $this->assertEquals($value, $this->feature->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->feature->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->feature->setUpdatedAs($value);
        $this->assertEquals($value, $this->feature->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->feature->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->feature->setDeletedAt($value);
        $this->assertEquals($value, $this->feature->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->feature->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->feature->setDeletedAs($value);
        $this->assertEquals($value, $this->feature->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->feature->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->feature->setDeletedBy($value);
        $this->assertEquals($value, $this->feature->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->feature->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->feature->setRestoredAt($value);
        $this->assertEquals($value, $this->feature->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->feature->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->feature->setRestoredBy($value);
        $this->assertEquals($value, $this->feature->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->feature->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->feature->setRestoredAs($value);
        $this->assertEquals($value, $this->feature->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->feature->getColumnMap());
    }
}
