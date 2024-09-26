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

use Zemit\Models\Abstracts\RecordAbstract;
use Zemit\Models\Abstracts\Interfaces\RecordAbstractInterface;
use Zemit\Models\Record;
use Zemit\Models\Interfaces\RecordInterface;

/**
 * Class RecordTest
 *
 * This class contains unit tests for the User class.
 */
class RecordTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public RecordInterface $record;
    
    protected function setUp(): void
    {
        $this->record = new Record();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Record::class, $this->record);
        $this->assertInstanceOf(RecordInterface::class, $this->record);
    
        // Abstract
        $this->assertInstanceOf(RecordAbstract::class, $this->record);
        $this->assertInstanceOf(RecordAbstractInterface::class, $this->record);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->record);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->record);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->record);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->record);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->record->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->record->setId($value);
        $this->assertEquals($value, $this->record->getId());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->record->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->record->setWorkspaceId($value);
        $this->assertEquals($value, $this->record->getWorkspaceId());
    }

    public function testGetTableId(): void
    {
        $this->assertEquals(null, $this->record->getTableId());
    }
    
    public function testSetTableId(): void
    {
        $value = uniqid();
        $this->record->setTableId($value);
        $this->assertEquals($value, $this->record->getTableId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->record->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->record->setUuid($value);
        $this->assertEquals($value, $this->record->getUuid());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->record->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->record->setName($value);
        $this->assertEquals($value, $this->record->getName());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->record->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->record->setDeleted($value);
        $this->assertEquals($value, $this->record->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->record->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->record->setCreatedAt($value);
        $this->assertEquals($value, $this->record->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->record->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->record->setCreatedBy($value);
        $this->assertEquals($value, $this->record->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->record->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->record->setCreatedAs($value);
        $this->assertEquals($value, $this->record->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->record->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->record->setUpdatedAt($value);
        $this->assertEquals($value, $this->record->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->record->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->record->setUpdatedBy($value);
        $this->assertEquals($value, $this->record->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->record->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->record->setUpdatedAs($value);
        $this->assertEquals($value, $this->record->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->record->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->record->setDeletedAt($value);
        $this->assertEquals($value, $this->record->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->record->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->record->setDeletedAs($value);
        $this->assertEquals($value, $this->record->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->record->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->record->setDeletedBy($value);
        $this->assertEquals($value, $this->record->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->record->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->record->setRestoredAt($value);
        $this->assertEquals($value, $this->record->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->record->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->record->setRestoredBy($value);
        $this->assertEquals($value, $this->record->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->record->getColumnMap());
    }
}
