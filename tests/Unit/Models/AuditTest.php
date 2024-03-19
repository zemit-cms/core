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

use Zemit\Models\Abstracts\AuditAbstract;
use Zemit\Models\Abstracts\Interfaces\AuditAbstractInterface;
use Zemit\Models\Audit;
use Zemit\Models\Interfaces\AuditInterface;

/**
 * Class AuditTest
 *
 * This class contains unit tests for the User class.
 */
class AuditTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public AuditInterface $audit;
    
    protected function setUp(): void
    {
        $this->audit = new Audit();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Audit::class, $this->audit);
        $this->assertInstanceOf(AuditInterface::class, $this->audit);
    
        // Abstract
        $this->assertInstanceOf(AuditAbstract::class, $this->audit);
        $this->assertInstanceOf(AuditAbstractInterface::class, $this->audit);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->audit);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->audit);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->audit);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->audit);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->audit->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->audit->setId($value);
        $this->assertEquals($value, $this->audit->getId());
    }

    public function testGetParentId(): void
    {
        $this->assertEquals(null, $this->audit->getParentId());
    }
    
    public function testSetParentId(): void
    {
        $value = uniqid();
        $this->audit->setParentId($value);
        $this->assertEquals($value, $this->audit->getParentId());
    }

    public function testGetModel(): void
    {
        $this->assertEquals(null, $this->audit->getModel());
    }
    
    public function testSetModel(): void
    {
        $value = uniqid();
        $this->audit->setModel($value);
        $this->assertEquals($value, $this->audit->getModel());
    }

    public function testGetTable(): void
    {
        $this->assertEquals(null, $this->audit->getTable());
    }
    
    public function testSetTable(): void
    {
        $value = uniqid();
        $this->audit->setTable($value);
        $this->assertEquals($value, $this->audit->getTable());
    }

    public function testGetPrimary(): void
    {
        $this->assertEquals(null, $this->audit->getPrimary());
    }
    
    public function testSetPrimary(): void
    {
        $value = uniqid();
        $this->audit->setPrimary($value);
        $this->assertEquals($value, $this->audit->getPrimary());
    }

    public function testGetEvent(): void
    {
        $this->assertEquals('other', $this->audit->getEvent());
    }
    
    public function testSetEvent(): void
    {
        $value = uniqid();
        $this->audit->setEvent($value);
        $this->assertEquals($value, $this->audit->getEvent());
    }

    public function testGetColumns(): void
    {
        $this->assertEquals(null, $this->audit->getColumns());
    }
    
    public function testSetColumns(): void
    {
        $value = uniqid();
        $this->audit->setColumns($value);
        $this->assertEquals($value, $this->audit->getColumns());
    }

    public function testGetBefore(): void
    {
        $this->assertEquals(null, $this->audit->getBefore());
    }
    
    public function testSetBefore(): void
    {
        $value = uniqid();
        $this->audit->setBefore($value);
        $this->assertEquals($value, $this->audit->getBefore());
    }

    public function testGetAfter(): void
    {
        $this->assertEquals(null, $this->audit->getAfter());
    }
    
    public function testSetAfter(): void
    {
        $value = uniqid();
        $this->audit->setAfter($value);
        $this->assertEquals($value, $this->audit->getAfter());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->audit->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->audit->setDeleted($value);
        $this->assertEquals($value, $this->audit->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->audit->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->audit->setCreatedAt($value);
        $this->assertEquals($value, $this->audit->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->audit->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->audit->setCreatedBy($value);
        $this->assertEquals($value, $this->audit->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->audit->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->audit->setCreatedAs($value);
        $this->assertEquals($value, $this->audit->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->audit->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->audit->setUpdatedAt($value);
        $this->assertEquals($value, $this->audit->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->audit->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->audit->setUpdatedBy($value);
        $this->assertEquals($value, $this->audit->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->audit->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->audit->setUpdatedAs($value);
        $this->assertEquals($value, $this->audit->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->audit->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->audit->setDeletedAt($value);
        $this->assertEquals($value, $this->audit->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->audit->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->audit->setDeletedAs($value);
        $this->assertEquals($value, $this->audit->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->audit->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->audit->setDeletedBy($value);
        $this->assertEquals($value, $this->audit->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->audit->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->audit->setRestoredAt($value);
        $this->assertEquals($value, $this->audit->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->audit->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->audit->setRestoredBy($value);
        $this->assertEquals($value, $this->audit->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->audit->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->audit->setRestoredAs($value);
        $this->assertEquals($value, $this->audit->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->audit->getColumnMap());
    }
}