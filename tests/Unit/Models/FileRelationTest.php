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

use Zemit\Models\Abstracts\FileRelationAbstract;
use Zemit\Models\Abstracts\Interfaces\FileRelationAbstractInterface;
use Zemit\Models\FileRelation;
use Zemit\Models\Interfaces\FileRelationInterface;

/**
 * Class FileRelationTest
 *
 * This class contains unit tests for the User class.
 */
class FileRelationTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public FileRelationInterface $fileRelation;
    
    protected function setUp(): void
    {
        $this->fileRelation = new FileRelation();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(FileRelation::class, $this->fileRelation);
        $this->assertInstanceOf(FileRelationInterface::class, $this->fileRelation);
    
        // Abstract
        $this->assertInstanceOf(FileRelationAbstract::class, $this->fileRelation);
        $this->assertInstanceOf(FileRelationAbstractInterface::class, $this->fileRelation);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->fileRelation);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->fileRelation);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->fileRelation);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->fileRelation);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->fileRelation->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->fileRelation->setId($value);
        $this->assertEquals($value, $this->fileRelation->getId());
    }

    public function testGetFileId(): void
    {
        $this->assertEquals(null, $this->fileRelation->getFileId());
    }
    
    public function testSetFileId(): void
    {
        $value = uniqid();
        $this->fileRelation->setFileId($value);
        $this->assertEquals($value, $this->fileRelation->getFileId());
    }

    public function testGetCategory(): void
    {
        $this->assertEquals('other', $this->fileRelation->getCategory());
    }
    
    public function testSetCategory(): void
    {
        $value = uniqid();
        $this->fileRelation->setCategory($value);
        $this->assertEquals($value, $this->fileRelation->getCategory());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->fileRelation->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->fileRelation->setDeleted($value);
        $this->assertEquals($value, $this->fileRelation->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->fileRelation->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->fileRelation->setCreatedAt($value);
        $this->assertEquals($value, $this->fileRelation->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->fileRelation->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->fileRelation->setCreatedBy($value);
        $this->assertEquals($value, $this->fileRelation->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->fileRelation->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->fileRelation->setCreatedAs($value);
        $this->assertEquals($value, $this->fileRelation->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->fileRelation->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->fileRelation->setUpdatedAt($value);
        $this->assertEquals($value, $this->fileRelation->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->fileRelation->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->fileRelation->setUpdatedBy($value);
        $this->assertEquals($value, $this->fileRelation->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->fileRelation->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->fileRelation->setUpdatedAs($value);
        $this->assertEquals($value, $this->fileRelation->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->fileRelation->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->fileRelation->setDeletedAt($value);
        $this->assertEquals($value, $this->fileRelation->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->fileRelation->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->fileRelation->setDeletedAs($value);
        $this->assertEquals($value, $this->fileRelation->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->fileRelation->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->fileRelation->setDeletedBy($value);
        $this->assertEquals($value, $this->fileRelation->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->fileRelation->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->fileRelation->setRestoredAt($value);
        $this->assertEquals($value, $this->fileRelation->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->fileRelation->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->fileRelation->setRestoredBy($value);
        $this->assertEquals($value, $this->fileRelation->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->fileRelation->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->fileRelation->setRestoredAs($value);
        $this->assertEquals($value, $this->fileRelation->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->fileRelation->getColumnMap());
    }
}