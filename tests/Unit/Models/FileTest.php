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

use Zemit\Models\Abstracts\FileAbstract;
use Zemit\Models\Abstracts\Interfaces\FileAbstractInterface;
use Zemit\Models\File;
use Zemit\Models\Interfaces\FileInterface;

/**
 * Class FileTest
 *
 * This class contains unit tests for the User class.
 */
class FileTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public FileInterface $file;
    
    protected function setUp(): void
    {
        $this->file = new File();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(File::class, $this->file);
        $this->assertInstanceOf(FileInterface::class, $this->file);
    
        // Abstract
        $this->assertInstanceOf(FileAbstract::class, $this->file);
        $this->assertInstanceOf(FileAbstractInterface::class, $this->file);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->file);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->file);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->file);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->file);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->file->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->file->setId($value);
        $this->assertEquals($value, $this->file->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->file->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->file->setUserId($value);
        $this->assertEquals($value, $this->file->getUserId());
    }

    public function testGetCategory(): void
    {
        $this->assertEquals('other', $this->file->getCategory());
    }
    
    public function testSetCategory(): void
    {
        $value = uniqid();
        $this->file->setCategory($value);
        $this->assertEquals($value, $this->file->getCategory());
    }

    public function testGetKey(): void
    {
        $this->assertEquals(null, $this->file->getKey());
    }
    
    public function testSetKey(): void
    {
        $value = uniqid();
        $this->file->setKey($value);
        $this->assertEquals($value, $this->file->getKey());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(null, $this->file->getPath());
    }
    
    public function testSetPath(): void
    {
        $value = uniqid();
        $this->file->setPath($value);
        $this->assertEquals($value, $this->file->getPath());
    }

    public function testGetType(): void
    {
        $this->assertEquals(null, $this->file->getType());
    }
    
    public function testSetType(): void
    {
        $value = uniqid();
        $this->file->setType($value);
        $this->assertEquals($value, $this->file->getType());
    }

    public function testGetTypeReal(): void
    {
        $this->assertEquals(null, $this->file->getTypeReal());
    }
    
    public function testSetTypeReal(): void
    {
        $value = uniqid();
        $this->file->setTypeReal($value);
        $this->assertEquals($value, $this->file->getTypeReal());
    }

    public function testGetExtension(): void
    {
        $this->assertEquals(null, $this->file->getExtension());
    }
    
    public function testSetExtension(): void
    {
        $value = uniqid();
        $this->file->setExtension($value);
        $this->assertEquals($value, $this->file->getExtension());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->file->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->file->setName($value);
        $this->assertEquals($value, $this->file->getName());
    }

    public function testGetNameTemp(): void
    {
        $this->assertEquals(null, $this->file->getNameTemp());
    }
    
    public function testSetNameTemp(): void
    {
        $value = uniqid();
        $this->file->setNameTemp($value);
        $this->assertEquals($value, $this->file->getNameTemp());
    }

    public function testGetSize(): void
    {
        $this->assertEquals(null, $this->file->getSize());
    }
    
    public function testSetSize(): void
    {
        $value = uniqid();
        $this->file->setSize($value);
        $this->assertEquals($value, $this->file->getSize());
    }

    public function testGetError(): void
    {
        $this->assertEquals(null, $this->file->getError());
    }
    
    public function testSetError(): void
    {
        $value = uniqid();
        $this->file->setError($value);
        $this->assertEquals($value, $this->file->getError());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->file->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->file->setDeleted($value);
        $this->assertEquals($value, $this->file->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->file->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->file->setCreatedAt($value);
        $this->assertEquals($value, $this->file->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->file->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->file->setCreatedBy($value);
        $this->assertEquals($value, $this->file->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->file->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->file->setCreatedAs($value);
        $this->assertEquals($value, $this->file->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->file->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->file->setUpdatedAt($value);
        $this->assertEquals($value, $this->file->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->file->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->file->setUpdatedBy($value);
        $this->assertEquals($value, $this->file->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->file->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->file->setUpdatedAs($value);
        $this->assertEquals($value, $this->file->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->file->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->file->setDeletedAt($value);
        $this->assertEquals($value, $this->file->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->file->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->file->setDeletedAs($value);
        $this->assertEquals($value, $this->file->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->file->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->file->setDeletedBy($value);
        $this->assertEquals($value, $this->file->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->file->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->file->setRestoredAt($value);
        $this->assertEquals($value, $this->file->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->file->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->file->setRestoredBy($value);
        $this->assertEquals($value, $this->file->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->file->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->file->setRestoredAs($value);
        $this->assertEquals($value, $this->file->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->file->getColumnMap());
    }
}
