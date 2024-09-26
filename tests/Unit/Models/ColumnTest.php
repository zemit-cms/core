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

use Zemit\Models\Abstracts\ColumnAbstract;
use Zemit\Models\Abstracts\Interfaces\ColumnAbstractInterface;
use Zemit\Models\Column;
use Zemit\Models\Interfaces\ColumnInterface;

/**
 * Class ColumnTest
 *
 * This class contains unit tests for the User class.
 */
class ColumnTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public ColumnInterface $column;
    
    protected function setUp(): void
    {
        $this->column = new Column();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Column::class, $this->column);
        $this->assertInstanceOf(ColumnInterface::class, $this->column);
    
        // Abstract
        $this->assertInstanceOf(ColumnAbstract::class, $this->column);
        $this->assertInstanceOf(ColumnAbstractInterface::class, $this->column);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->column);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->column);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->column);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->column);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->column->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->column->setId($value);
        $this->assertEquals($value, $this->column->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->column->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->column->setUuid($value);
        $this->assertEquals($value, $this->column->getUuid());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->column->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->column->setWorkspaceId($value);
        $this->assertEquals($value, $this->column->getWorkspaceId());
    }

    public function testGetTableId(): void
    {
        $this->assertEquals(null, $this->column->getTableId());
    }
    
    public function testSetTableId(): void
    {
        $value = uniqid();
        $this->column->setTableId($value);
        $this->assertEquals($value, $this->column->getTableId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->column->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->column->setName($value);
        $this->assertEquals($value, $this->column->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->column->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->column->setDescription($value);
        $this->assertEquals($value, $this->column->getDescription());
    }

    public function testGetType(): void
    {
        $this->assertEquals('text', $this->column->getType());
    }
    
    public function testSetType(): void
    {
        $value = uniqid();
        $this->column->setType($value);
        $this->assertEquals($value, $this->column->getType());
    }

    public function testGetValidationRegex(): void
    {
        $this->assertEquals(null, $this->column->getValidationRegex());
    }
    
    public function testSetValidationRegex(): void
    {
        $value = uniqid();
        $this->column->setValidationRegex($value);
        $this->assertEquals($value, $this->column->getValidationRegex());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->column->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->column->setDeleted($value);
        $this->assertEquals($value, $this->column->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->column->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->column->setCreatedAt($value);
        $this->assertEquals($value, $this->column->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->column->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->column->setCreatedBy($value);
        $this->assertEquals($value, $this->column->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->column->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->column->setCreatedAs($value);
        $this->assertEquals($value, $this->column->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->column->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->column->setUpdatedAt($value);
        $this->assertEquals($value, $this->column->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->column->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->column->setUpdatedBy($value);
        $this->assertEquals($value, $this->column->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->column->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->column->setUpdatedAs($value);
        $this->assertEquals($value, $this->column->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->column->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->column->setDeletedAt($value);
        $this->assertEquals($value, $this->column->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->column->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->column->setDeletedAs($value);
        $this->assertEquals($value, $this->column->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->column->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->column->setDeletedBy($value);
        $this->assertEquals($value, $this->column->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->column->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->column->setRestoredAt($value);
        $this->assertEquals($value, $this->column->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->column->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->column->setRestoredBy($value);
        $this->assertEquals($value, $this->column->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->column->getColumnMap());
    }
}
