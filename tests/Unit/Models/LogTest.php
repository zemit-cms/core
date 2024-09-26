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

use Zemit\Models\Abstracts\LogAbstract;
use Zemit\Models\Abstracts\Interfaces\LogAbstractInterface;
use Zemit\Models\Log;
use Zemit\Models\Interfaces\LogInterface;

/**
 * Class LogTest
 *
 * This class contains unit tests for the User class.
 */
class LogTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public LogInterface $log;
    
    protected function setUp(): void
    {
        $this->log = new Log();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Log::class, $this->log);
        $this->assertInstanceOf(LogInterface::class, $this->log);
    
        // Abstract
        $this->assertInstanceOf(LogAbstract::class, $this->log);
        $this->assertInstanceOf(LogAbstractInterface::class, $this->log);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->log);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->log);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->log);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->log);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->log->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->log->setId($value);
        $this->assertEquals($value, $this->log->getId());
    }

    public function testGetLevel(): void
    {
        $this->assertEquals(null, $this->log->getLevel());
    }
    
    public function testSetLevel(): void
    {
        $value = uniqid();
        $this->log->setLevel($value);
        $this->assertEquals($value, $this->log->getLevel());
    }

    public function testGetType(): void
    {
        $this->assertEquals('other', $this->log->getType());
    }
    
    public function testSetType(): void
    {
        $value = uniqid();
        $this->log->setType($value);
        $this->assertEquals($value, $this->log->getType());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->log->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->log->setName($value);
        $this->assertEquals($value, $this->log->getName());
    }

    public function testGetMessage(): void
    {
        $this->assertEquals(null, $this->log->getMessage());
    }
    
    public function testSetMessage(): void
    {
        $value = uniqid();
        $this->log->setMessage($value);
        $this->assertEquals($value, $this->log->getMessage());
    }

    public function testGetContext(): void
    {
        $this->assertEquals(null, $this->log->getContext());
    }
    
    public function testSetContext(): void
    {
        $value = uniqid();
        $this->log->setContext($value);
        $this->assertEquals($value, $this->log->getContext());
    }

    public function testGetDate(): void
    {
        $this->assertEquals(null, $this->log->getDate());
    }
    
    public function testSetDate(): void
    {
        $value = uniqid();
        $this->log->setDate($value);
        $this->assertEquals($value, $this->log->getDate());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->log->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->log->setDeleted($value);
        $this->assertEquals($value, $this->log->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->log->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->log->setCreatedAt($value);
        $this->assertEquals($value, $this->log->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->log->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->log->setCreatedBy($value);
        $this->assertEquals($value, $this->log->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->log->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->log->setCreatedAs($value);
        $this->assertEquals($value, $this->log->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->log->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->log->setUpdatedAt($value);
        $this->assertEquals($value, $this->log->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->log->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->log->setUpdatedBy($value);
        $this->assertEquals($value, $this->log->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->log->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->log->setUpdatedAs($value);
        $this->assertEquals($value, $this->log->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->log->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->log->setDeletedAt($value);
        $this->assertEquals($value, $this->log->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->log->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->log->setDeletedAs($value);
        $this->assertEquals($value, $this->log->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->log->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->log->setDeletedBy($value);
        $this->assertEquals($value, $this->log->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->log->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->log->setRestoredAt($value);
        $this->assertEquals($value, $this->log->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->log->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->log->setRestoredBy($value);
        $this->assertEquals($value, $this->log->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->log->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->log->setRestoredAs($value);
        $this->assertEquals($value, $this->log->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->log->getColumnMap());
    }
}
