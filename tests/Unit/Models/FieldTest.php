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

use Zemit\Models\Abstracts\FieldAbstract;
use Zemit\Models\Abstracts\Interfaces\FieldAbstractInterface;
use Zemit\Models\Field;
use Zemit\Models\Interfaces\FieldInterface;

/**
 * Class FieldTest
 *
 * This class contains unit tests for the User class.
 */
class FieldTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public FieldInterface $field;
    
    protected function setUp(): void
    {
        $this->field = new Field();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Field::class, $this->field);
        $this->assertInstanceOf(FieldInterface::class, $this->field);
    
        // Abstract
        $this->assertInstanceOf(FieldAbstract::class, $this->field);
        $this->assertInstanceOf(FieldAbstractInterface::class, $this->field);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->field);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->field);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->field);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->field);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->field->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->field->setId($value);
        $this->assertEquals($value, $this->field->getId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->field->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->field->setSiteId($value);
        $this->assertEquals($value, $this->field->getSiteId());
    }

    public function testGetTableId(): void
    {
        $this->assertEquals(null, $this->field->getTableId());
    }
    
    public function testSetTableId(): void
    {
        $value = uniqid();
        $this->field->setTableId($value);
        $this->assertEquals($value, $this->field->getTableId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->field->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->field->setName($value);
        $this->assertEquals($value, $this->field->getName());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->field->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->field->setIndex($value);
        $this->assertEquals($value, $this->field->getIndex());
    }

    public function testGetType(): void
    {
        $this->assertEquals('text', $this->field->getType());
    }
    
    public function testSetType(): void
    {
        $value = uniqid();
        $this->field->setType($value);
        $this->assertEquals($value, $this->field->getType());
    }

    public function testGetValidationRegex(): void
    {
        $this->assertEquals(null, $this->field->getValidationRegex());
    }
    
    public function testSetValidationRegex(): void
    {
        $value = uniqid();
        $this->field->setValidationRegex($value);
        $this->assertEquals($value, $this->field->getValidationRegex());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->field->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->field->setDeleted($value);
        $this->assertEquals($value, $this->field->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->field->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->field->setCreatedAt($value);
        $this->assertEquals($value, $this->field->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->field->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->field->setCreatedBy($value);
        $this->assertEquals($value, $this->field->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->field->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->field->setCreatedAs($value);
        $this->assertEquals($value, $this->field->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->field->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->field->setUpdatedAt($value);
        $this->assertEquals($value, $this->field->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->field->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->field->setUpdatedBy($value);
        $this->assertEquals($value, $this->field->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->field->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->field->setUpdatedAs($value);
        $this->assertEquals($value, $this->field->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->field->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->field->setDeletedAt($value);
        $this->assertEquals($value, $this->field->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->field->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->field->setDeletedAs($value);
        $this->assertEquals($value, $this->field->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->field->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->field->setDeletedBy($value);
        $this->assertEquals($value, $this->field->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->field->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->field->setRestoredAt($value);
        $this->assertEquals($value, $this->field->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->field->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->field->setRestoredBy($value);
        $this->assertEquals($value, $this->field->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->field->getColumnMap());
    }
}