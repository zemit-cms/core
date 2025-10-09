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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->fileRelation->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->fileRelation->setUuid($value);
        $this->assertEquals($value, $this->fileRelation->getUuid());
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

    public function testGetRelationTable(): void
    {
        $this->assertEquals(null, $this->fileRelation->getRelationTable());
    }
    
    public function testSetRelationTable(): void
    {
        $value = uniqid();
        $this->fileRelation->setRelationTable($value);
        $this->assertEquals($value, $this->fileRelation->getRelationTable());
    }

    public function testGetRelationId(): void
    {
        $this->assertEquals(null, $this->fileRelation->getRelationId());
    }
    
    public function testSetRelationId(): void
    {
        $value = uniqid();
        $this->fileRelation->setRelationId($value);
        $this->assertEquals($value, $this->fileRelation->getRelationId());
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
        $this->assertEquals('current_timestamp()', $this->fileRelation->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->fileRelation->getColumnMap());
    }
}
