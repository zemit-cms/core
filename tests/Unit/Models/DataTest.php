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

use Zemit\Models\Abstracts\DataAbstract;
use Zemit\Models\Abstracts\Interfaces\DataAbstractInterface;
use Zemit\Models\Data;
use Zemit\Models\Interfaces\DataInterface;

/**
 * Class DataTest
 *
 * This class contains unit tests for the User class.
 */
class DataTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public DataInterface $data;
    
    protected function setUp(): void
    {
        $this->data = new Data();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Data::class, $this->data);
        $this->assertInstanceOf(DataInterface::class, $this->data);
    
        // Abstract
        $this->assertInstanceOf(DataAbstract::class, $this->data);
        $this->assertInstanceOf(DataAbstractInterface::class, $this->data);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->data);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->data);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->data);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->data);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->data->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->data->setId($value);
        $this->assertEquals($value, $this->data->getId());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->data->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->data->setWorkspaceId($value);
        $this->assertEquals($value, $this->data->getWorkspaceId());
    }

    public function testGetTableId(): void
    {
        $this->assertEquals(null, $this->data->getTableId());
    }
    
    public function testSetTableId(): void
    {
        $value = uniqid();
        $this->data->setTableId($value);
        $this->assertEquals($value, $this->data->getTableId());
    }

    public function testGetColumnId(): void
    {
        $this->assertEquals(null, $this->data->getColumnId());
    }
    
    public function testSetColumnId(): void
    {
        $value = uniqid();
        $this->data->setColumnId($value);
        $this->assertEquals($value, $this->data->getColumnId());
    }

    public function testGetRecordId(): void
    {
        $this->assertEquals(null, $this->data->getRecordId());
    }
    
    public function testSetRecordId(): void
    {
        $value = uniqid();
        $this->data->setRecordId($value);
        $this->assertEquals($value, $this->data->getRecordId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->data->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->data->setUuid($value);
        $this->assertEquals($value, $this->data->getUuid());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(null, $this->data->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->data->setValue($value);
        $this->assertEquals($value, $this->data->getValue());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->data->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->data->setDeleted($value);
        $this->assertEquals($value, $this->data->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->data->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->data->setCreatedAt($value);
        $this->assertEquals($value, $this->data->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->data->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->data->setCreatedBy($value);
        $this->assertEquals($value, $this->data->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->data->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->data->setCreatedAs($value);
        $this->assertEquals($value, $this->data->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->data->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->data->setUpdatedAt($value);
        $this->assertEquals($value, $this->data->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->data->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->data->setUpdatedBy($value);
        $this->assertEquals($value, $this->data->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->data->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->data->setUpdatedAs($value);
        $this->assertEquals($value, $this->data->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->data->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->data->setDeletedAt($value);
        $this->assertEquals($value, $this->data->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->data->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->data->setDeletedAs($value);
        $this->assertEquals($value, $this->data->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->data->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->data->setDeletedBy($value);
        $this->assertEquals($value, $this->data->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->data->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->data->setRestoredAt($value);
        $this->assertEquals($value, $this->data->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->data->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->data->setRestoredBy($value);
        $this->assertEquals($value, $this->data->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->data->getColumnMap());
    }
}
