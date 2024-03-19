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

use Zemit\Models\Abstracts\TranslateTableAbstract;
use Zemit\Models\Abstracts\Interfaces\TranslateTableAbstractInterface;
use Zemit\Models\TranslateTable;
use Zemit\Models\Interfaces\TranslateTableInterface;

/**
 * Class TranslateTableTest
 *
 * This class contains unit tests for the User class.
 */
class TranslateTableTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TranslateTableInterface $translateTable;
    
    protected function setUp(): void
    {
        $this->translateTable = new TranslateTable();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(TranslateTable::class, $this->translateTable);
        $this->assertInstanceOf(TranslateTableInterface::class, $this->translateTable);
    
        // Abstract
        $this->assertInstanceOf(TranslateTableAbstract::class, $this->translateTable);
        $this->assertInstanceOf(TranslateTableAbstractInterface::class, $this->translateTable);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->translateTable);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->translateTable);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->translateTable);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->translateTable);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->translateTable->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->translateTable->setId($value);
        $this->assertEquals($value, $this->translateTable->getId());
    }

    public function testGetTable(): void
    {
        $this->assertEquals(null, $this->translateTable->getTable());
    }
    
    public function testSetTable(): void
    {
        $value = uniqid();
        $this->translateTable->setTable($value);
        $this->assertEquals($value, $this->translateTable->getTable());
    }

    public function testGetLeftId(): void
    {
        $this->assertEquals(null, $this->translateTable->getLeftId());
    }
    
    public function testSetLeftId(): void
    {
        $value = uniqid();
        $this->translateTable->setLeftId($value);
        $this->assertEquals($value, $this->translateTable->getLeftId());
    }

    public function testGetRightId(): void
    {
        $this->assertEquals(null, $this->translateTable->getRightId());
    }
    
    public function testSetRightId(): void
    {
        $value = uniqid();
        $this->translateTable->setRightId($value);
        $this->assertEquals($value, $this->translateTable->getRightId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->translateTable->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->translateTable->setDeleted($value);
        $this->assertEquals($value, $this->translateTable->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->translateTable->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->translateTable->setCreatedAt($value);
        $this->assertEquals($value, $this->translateTable->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->translateTable->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->translateTable->setCreatedBy($value);
        $this->assertEquals($value, $this->translateTable->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->translateTable->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->translateTable->setCreatedAs($value);
        $this->assertEquals($value, $this->translateTable->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->translateTable->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->translateTable->setUpdatedAt($value);
        $this->assertEquals($value, $this->translateTable->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->translateTable->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->translateTable->setUpdatedBy($value);
        $this->assertEquals($value, $this->translateTable->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->translateTable->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->translateTable->setUpdatedAs($value);
        $this->assertEquals($value, $this->translateTable->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->translateTable->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->translateTable->setDeletedAt($value);
        $this->assertEquals($value, $this->translateTable->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->translateTable->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->translateTable->setDeletedAs($value);
        $this->assertEquals($value, $this->translateTable->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->translateTable->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->translateTable->setDeletedBy($value);
        $this->assertEquals($value, $this->translateTable->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->translateTable->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->translateTable->setRestoredAt($value);
        $this->assertEquals($value, $this->translateTable->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->translateTable->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->translateTable->setRestoredBy($value);
        $this->assertEquals($value, $this->translateTable->getRestoredBy());
    }

    public function testGetDeletedCopy1(): void
    {
        $this->assertEquals(null, $this->translateTable->getDeletedCopy1());
    }
    
    public function testSetDeletedCopy1(): void
    {
        $value = uniqid();
        $this->translateTable->setDeletedCopy1($value);
        $this->assertEquals($value, $this->translateTable->getDeletedCopy1());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->translateTable->getColumnMap());
    }
}