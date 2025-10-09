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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->auditDetail->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->auditDetail->setUuid($value);
        $this->assertEquals($value, $this->auditDetail->getUuid());
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
        $this->assertEquals('current_timestamp()', $this->auditDetail->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->auditDetail->getColumnMap());
    }
}
