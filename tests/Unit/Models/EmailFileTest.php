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

use Zemit\Models\Abstracts\EmailFileAbstract;
use Zemit\Models\Abstracts\Interfaces\EmailFileAbstractInterface;
use Zemit\Models\EmailFile;
use Zemit\Models\Interfaces\EmailFileInterface;

/**
 * Class EmailFileTest
 *
 * This class contains unit tests for the User class.
 */
class EmailFileTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public EmailFileInterface $emailFile;
    
    protected function setUp(): void
    {
        $this->emailFile = new EmailFile();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(EmailFile::class, $this->emailFile);
        $this->assertInstanceOf(EmailFileInterface::class, $this->emailFile);
    
        // Abstract
        $this->assertInstanceOf(EmailFileAbstract::class, $this->emailFile);
        $this->assertInstanceOf(EmailFileAbstractInterface::class, $this->emailFile);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->emailFile);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->emailFile);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->emailFile);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->emailFile);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->emailFile->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->emailFile->setId($value);
        $this->assertEquals($value, $this->emailFile->getId());
    }

    public function testGetEmailId(): void
    {
        $this->assertEquals(null, $this->emailFile->getEmailId());
    }
    
    public function testSetEmailId(): void
    {
        $value = uniqid();
        $this->emailFile->setEmailId($value);
        $this->assertEquals($value, $this->emailFile->getEmailId());
    }

    public function testGetFileId(): void
    {
        $this->assertEquals(null, $this->emailFile->getFileId());
    }
    
    public function testSetFileId(): void
    {
        $value = uniqid();
        $this->emailFile->setFileId($value);
        $this->assertEquals($value, $this->emailFile->getFileId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->emailFile->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->emailFile->setDeleted($value);
        $this->assertEquals($value, $this->emailFile->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->emailFile->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->emailFile->setCreatedAt($value);
        $this->assertEquals($value, $this->emailFile->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->emailFile->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->emailFile->setCreatedBy($value);
        $this->assertEquals($value, $this->emailFile->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->emailFile->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->emailFile->setCreatedAs($value);
        $this->assertEquals($value, $this->emailFile->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->emailFile->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->emailFile->setUpdatedAt($value);
        $this->assertEquals($value, $this->emailFile->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->emailFile->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->emailFile->setUpdatedBy($value);
        $this->assertEquals($value, $this->emailFile->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->emailFile->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->emailFile->setUpdatedAs($value);
        $this->assertEquals($value, $this->emailFile->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->emailFile->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->emailFile->setDeletedAt($value);
        $this->assertEquals($value, $this->emailFile->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->emailFile->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->emailFile->setDeletedAs($value);
        $this->assertEquals($value, $this->emailFile->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->emailFile->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->emailFile->setDeletedBy($value);
        $this->assertEquals($value, $this->emailFile->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->emailFile->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->emailFile->setRestoredAt($value);
        $this->assertEquals($value, $this->emailFile->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->emailFile->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->emailFile->setRestoredBy($value);
        $this->assertEquals($value, $this->emailFile->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->emailFile->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->emailFile->setRestoredAs($value);
        $this->assertEquals($value, $this->emailFile->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->emailFile->getColumnMap());
    }
}
