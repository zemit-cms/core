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

use Zemit\Models\Abstracts\BackupAbstract;
use Zemit\Models\Abstracts\Interfaces\BackupAbstractInterface;
use Zemit\Models\Backup;
use Zemit\Models\Interfaces\BackupInterface;

/**
 * Class BackupTest
 *
 * This class contains unit tests for the User class.
 */
class BackupTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public BackupInterface $backup;
    
    protected function setUp(): void
    {
        $this->backup = new Backup();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Backup::class, $this->backup);
        $this->assertInstanceOf(BackupInterface::class, $this->backup);
    
        // Abstract
        $this->assertInstanceOf(BackupAbstract::class, $this->backup);
        $this->assertInstanceOf(BackupAbstractInterface::class, $this->backup);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->backup);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->backup);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->backup);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->backup);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->backup->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->backup->setId($value);
        $this->assertEquals($value, $this->backup->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->backup->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->backup->setUuid($value);
        $this->assertEquals($value, $this->backup->getUuid());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->backup->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->backup->setName($value);
        $this->assertEquals($value, $this->backup->getName());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->backup->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->backup->setDeleted($value);
        $this->assertEquals($value, $this->backup->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->backup->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->backup->setCreatedAt($value);
        $this->assertEquals($value, $this->backup->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->backup->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->backup->setCreatedBy($value);
        $this->assertEquals($value, $this->backup->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->backup->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->backup->setCreatedAs($value);
        $this->assertEquals($value, $this->backup->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->backup->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->backup->setUpdatedAt($value);
        $this->assertEquals($value, $this->backup->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->backup->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->backup->setUpdatedBy($value);
        $this->assertEquals($value, $this->backup->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->backup->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->backup->setUpdatedAs($value);
        $this->assertEquals($value, $this->backup->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->backup->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->backup->setDeletedAt($value);
        $this->assertEquals($value, $this->backup->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->backup->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->backup->setDeletedAs($value);
        $this->assertEquals($value, $this->backup->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->backup->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->backup->setDeletedBy($value);
        $this->assertEquals($value, $this->backup->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->backup->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->backup->setRestoredAt($value);
        $this->assertEquals($value, $this->backup->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->backup->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->backup->setRestoredBy($value);
        $this->assertEquals($value, $this->backup->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->backup->getColumnMap());
    }
}
