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

use Zemit\Models\Abstracts\TypeAbstract;
use Zemit\Models\Abstracts\Interfaces\TypeAbstractInterface;
use Zemit\Models\Type;
use Zemit\Models\Interfaces\TypeInterface;

/**
 * Class TypeTest
 *
 * This class contains unit tests for the User class.
 */
class TypeTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TypeInterface $type;
    
    protected function setUp(): void
    {
        $this->type = new Type();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Type::class, $this->type);
        $this->assertInstanceOf(TypeInterface::class, $this->type);
    
        // Abstract
        $this->assertInstanceOf(TypeAbstract::class, $this->type);
        $this->assertInstanceOf(TypeAbstractInterface::class, $this->type);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->type);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->type);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->type);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->type);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->type->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->type->setId($value);
        $this->assertEquals($value, $this->type->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->type->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->type->setIndex($value);
        $this->assertEquals($value, $this->type->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->type->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->type->setLabel($value);
        $this->assertEquals($value, $this->type->getLabel());
    }

    public function testGetPosition(): void
    {
        $this->assertEquals(null, $this->type->getPosition());
    }
    
    public function testSetPosition(): void
    {
        $value = uniqid();
        $this->type->setPosition($value);
        $this->assertEquals($value, $this->type->getPosition());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->type->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->type->setDeleted($value);
        $this->assertEquals($value, $this->type->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->type->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->type->setCreatedAt($value);
        $this->assertEquals($value, $this->type->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->type->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->type->setCreatedBy($value);
        $this->assertEquals($value, $this->type->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->type->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->type->setCreatedAs($value);
        $this->assertEquals($value, $this->type->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->type->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->type->setUpdatedAt($value);
        $this->assertEquals($value, $this->type->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->type->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->type->setUpdatedBy($value);
        $this->assertEquals($value, $this->type->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->type->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->type->setUpdatedAs($value);
        $this->assertEquals($value, $this->type->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->type->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->type->setDeletedAt($value);
        $this->assertEquals($value, $this->type->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->type->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->type->setDeletedAs($value);
        $this->assertEquals($value, $this->type->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->type->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->type->setDeletedBy($value);
        $this->assertEquals($value, $this->type->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->type->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->type->setRestoredAt($value);
        $this->assertEquals($value, $this->type->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->type->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->type->setRestoredBy($value);
        $this->assertEquals($value, $this->type->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->type->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->type->setRestoredAs($value);
        $this->assertEquals($value, $this->type->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->type->getColumnMap());
    }
}