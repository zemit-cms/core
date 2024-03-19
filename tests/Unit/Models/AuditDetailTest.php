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

use Zemit\Models\Abstracts\AuditDetailAbstract;
use Zemit\Models\Abstracts\Interfaces\AuditDetailAbstractInterface;
use Zemit\Models\AuditDetail;
use Zemit\Models\Interfaces\AuditDetailInterface;

/**
 * Class AuditDetailTest
 *
 * This class contains unit tests for the User class.
 */
class AuditDetailTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public AuditDetailInterface $auditDetail;
    
    protected function setUp(): void
    {
        $this->auditDetail = new AuditDetail();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(AuditDetail::class, $this->auditDetail);
        $this->assertInstanceOf(AuditDetailInterface::class, $this->auditDetail);
    
        // Abstract
        $this->assertInstanceOf(AuditDetailAbstract::class, $this->auditDetail);
        $this->assertInstanceOf(AuditDetailAbstractInterface::class, $this->auditDetail);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->auditDetail);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->auditDetail);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->auditDetail);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->auditDetail);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->auditDetail->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->auditDetail->setId($value);
        $this->assertEquals($value, $this->auditDetail->getId());
    }

    public function testGetAuditId(): void
    {
        $this->assertEquals(null, $this->auditDetail->getAuditId());
    }
    
    public function testSetAuditId(): void
    {
        $value = uniqid();
        $this->auditDetail->setAuditId($value);
        $this->assertEquals($value, $this->auditDetail->getAuditId());
    }

    public function testGetModel(): void
    {
        $this->assertEquals(null, $this->auditDetail->getModel());
    }
    
    public function testSetModel(): void
    {
        $value = uniqid();
        $this->auditDetail->setModel($value);
        $this->assertEquals($value, $this->auditDetail->getModel());
    }

    public function testGetTable(): void
    {
        $this->assertEquals(null, $this->auditDetail->getTable());
    }
    
    public function testSetTable(): void
    {
        $value = uniqid();
        $this->auditDetail->setTable($value);
        $this->assertEquals($value, $this->auditDetail->getTable());
    }

    public function testGetPrimary(): void
    {
        $this->assertEquals(null, $this->auditDetail->getPrimary());
    }
    
    public function testSetPrimary(): void
    {
        $value = uniqid();
        $this->auditDetail->setPrimary($value);
        $this->assertEquals($value, $this->auditDetail->getPrimary());
    }

    public function testGetEvent(): void
    {
        $this->assertEquals('other', $this->auditDetail->getEvent());
    }
    
    public function testSetEvent(): void
    {
        $value = uniqid();
        $this->auditDetail->setEvent($value);
        $this->assertEquals($value, $this->auditDetail->getEvent());
    }

    public function testGetColumn(): void
    {
        $this->assertEquals(null, $this->auditDetail->getColumn());
    }
    
    public function testSetColumn(): void
    {
        $value = uniqid();
        $this->auditDetail->setColumn($value);
        $this->assertEquals($value, $this->auditDetail->getColumn());
    }

    public function testGetMap(): void
    {
        $this->assertEquals(null, $this->auditDetail->getMap());
    }
    
    public function testSetMap(): void
    {
        $value = uniqid();
        $this->auditDetail->setMap($value);
        $this->assertEquals($value, $this->auditDetail->getMap());
    }

    public function testGetBefore(): void
    {
        $this->assertEquals(null, $this->auditDetail->getBefore());
    }
    
    public function testSetBefore(): void
    {
        $value = uniqid();
        $this->auditDetail->setBefore($value);
        $this->assertEquals($value, $this->auditDetail->getBefore());
    }

    public function testGetAfter(): void
    {
        $this->assertEquals(null, $this->auditDetail->getAfter());
    }
    
    public function testSetAfter(): void
    {
        $value = uniqid();
        $this->auditDetail->setAfter($value);
        $this->assertEquals($value, $this->auditDetail->getAfter());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->auditDetail->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->auditDetail->setDeleted($value);
        $this->assertEquals($value, $this->auditDetail->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->auditDetail->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->auditDetail->setCreatedAt($value);
        $this->assertEquals($value, $this->auditDetail->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->auditDetail->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->auditDetail->setCreatedBy($value);
        $this->assertEquals($value, $this->auditDetail->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->auditDetail->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->auditDetail->setCreatedAs($value);
        $this->assertEquals($value, $this->auditDetail->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->auditDetail->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->auditDetail->setUpdatedAt($value);
        $this->assertEquals($value, $this->auditDetail->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->auditDetail->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->auditDetail->setUpdatedBy($value);
        $this->assertEquals($value, $this->auditDetail->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->auditDetail->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->auditDetail->setUpdatedAs($value);
        $this->assertEquals($value, $this->auditDetail->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->auditDetail->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->auditDetail->setDeletedAt($value);
        $this->assertEquals($value, $this->auditDetail->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->auditDetail->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->auditDetail->setDeletedBy($value);
        $this->assertEquals($value, $this->auditDetail->getDeletedBy());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->auditDetail->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->auditDetail->setDeletedAs($value);
        $this->assertEquals($value, $this->auditDetail->getDeletedAs());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->auditDetail->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->auditDetail->setRestoredAt($value);
        $this->assertEquals($value, $this->auditDetail->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->auditDetail->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->auditDetail->setRestoredBy($value);
        $this->assertEquals($value, $this->auditDetail->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->auditDetail->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->auditDetail->setRestoredAs($value);
        $this->assertEquals($value, $this->auditDetail->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->auditDetail->getColumnMap());
    }
}