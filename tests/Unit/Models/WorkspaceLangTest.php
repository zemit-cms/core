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

use Zemit\Models\Abstracts\WorkspaceLangAbstract;
use Zemit\Models\Abstracts\Interfaces\WorkspaceLangAbstractInterface;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\Interfaces\WorkspaceLangInterface;

/**
 * Class WorkspaceLangTest
 *
 * This class contains unit tests for the User class.
 */
class WorkspaceLangTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public WorkspaceLangInterface $workspaceLang;
    
    protected function setUp(): void
    {
        $this->workspaceLang = new WorkspaceLang();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(WorkspaceLang::class, $this->workspaceLang);
        $this->assertInstanceOf(WorkspaceLangInterface::class, $this->workspaceLang);
    
        // Abstract
        $this->assertInstanceOf(WorkspaceLangAbstract::class, $this->workspaceLang);
        $this->assertInstanceOf(WorkspaceLangAbstractInterface::class, $this->workspaceLang);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->workspaceLang);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->workspaceLang);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->workspaceLang);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->workspaceLang);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setId($value);
        $this->assertEquals($value, $this->workspaceLang->getId());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setWorkspaceId($value);
        $this->assertEquals($value, $this->workspaceLang->getWorkspaceId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setLangId($value);
        $this->assertEquals($value, $this->workspaceLang->getLangId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeleted($value);
        $this->assertEquals($value, $this->workspaceLang->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->workspaceLang->setCreatedAt($value);
        $this->assertEquals($value, $this->workspaceLang->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->workspaceLang->setCreatedBy($value);
        $this->assertEquals($value, $this->workspaceLang->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->workspaceLang->setCreatedAs($value);
        $this->assertEquals($value, $this->workspaceLang->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->workspaceLang->setUpdatedAt($value);
        $this->assertEquals($value, $this->workspaceLang->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->workspaceLang->setUpdatedBy($value);
        $this->assertEquals($value, $this->workspaceLang->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->workspaceLang->setUpdatedAs($value);
        $this->assertEquals($value, $this->workspaceLang->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeletedAt($value);
        $this->assertEquals($value, $this->workspaceLang->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeletedAs($value);
        $this->assertEquals($value, $this->workspaceLang->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeletedBy($value);
        $this->assertEquals($value, $this->workspaceLang->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->workspaceLang->setRestoredAt($value);
        $this->assertEquals($value, $this->workspaceLang->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->workspaceLang->setRestoredBy($value);
        $this->assertEquals($value, $this->workspaceLang->getRestoredBy());
    }

    public function testGetDeletedCopy1(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeletedCopy1());
    }
    
    public function testSetDeletedCopy1(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeletedCopy1($value);
        $this->assertEquals($value, $this->workspaceLang->getDeletedCopy1());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->workspaceLang->getColumnMap());
    }
}
