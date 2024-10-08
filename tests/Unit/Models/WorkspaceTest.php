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

use Zemit\Models\Abstracts\WorkspaceAbstract;
use Zemit\Models\Abstracts\Interfaces\WorkspaceAbstractInterface;
use Zemit\Models\Workspace;
use Zemit\Models\Interfaces\WorkspaceInterface;

/**
 * Class WorkspaceTest
 *
 * This class contains unit tests for the User class.
 */
class WorkspaceTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public WorkspaceInterface $workspace;
    
    protected function setUp(): void
    {
        $this->workspace = new Workspace();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Workspace::class, $this->workspace);
        $this->assertInstanceOf(WorkspaceInterface::class, $this->workspace);
    
        // Abstract
        $this->assertInstanceOf(WorkspaceAbstract::class, $this->workspace);
        $this->assertInstanceOf(WorkspaceAbstractInterface::class, $this->workspace);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->workspace);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->workspace);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->workspace);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->workspace);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->workspace->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->workspace->setId($value);
        $this->assertEquals($value, $this->workspace->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->workspace->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->workspace->setUuid($value);
        $this->assertEquals($value, $this->workspace->getUuid());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->workspace->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->workspace->setName($value);
        $this->assertEquals($value, $this->workspace->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->workspace->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->workspace->setDescription($value);
        $this->assertEquals($value, $this->workspace->getDescription());
    }

    public function testGetIcon(): void
    {
        $this->assertEquals(null, $this->workspace->getIcon());
    }
    
    public function testSetIcon(): void
    {
        $value = uniqid();
        $this->workspace->setIcon($value);
        $this->assertEquals($value, $this->workspace->getIcon());
    }

    public function testGetColor(): void
    {
        $this->assertEquals(null, $this->workspace->getColor());
    }
    
    public function testSetColor(): void
    {
        $value = uniqid();
        $this->workspace->setColor($value);
        $this->assertEquals($value, $this->workspace->getColor());
    }

    public function testGetStatus(): void
    {
        $this->assertEquals('active', $this->workspace->getStatus());
    }
    
    public function testSetStatus(): void
    {
        $value = uniqid();
        $this->workspace->setStatus($value);
        $this->assertEquals($value, $this->workspace->getStatus());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->workspace->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->workspace->setDeleted($value);
        $this->assertEquals($value, $this->workspace->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->workspace->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->workspace->setCreatedAt($value);
        $this->assertEquals($value, $this->workspace->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->workspace->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->workspace->setCreatedBy($value);
        $this->assertEquals($value, $this->workspace->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->workspace->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->workspace->setCreatedAs($value);
        $this->assertEquals($value, $this->workspace->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->workspace->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->workspace->setUpdatedAt($value);
        $this->assertEquals($value, $this->workspace->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->workspace->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->workspace->setUpdatedBy($value);
        $this->assertEquals($value, $this->workspace->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->workspace->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->workspace->setUpdatedAs($value);
        $this->assertEquals($value, $this->workspace->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->workspace->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->workspace->setDeletedAt($value);
        $this->assertEquals($value, $this->workspace->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->workspace->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->workspace->setDeletedAs($value);
        $this->assertEquals($value, $this->workspace->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->workspace->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->workspace->setDeletedBy($value);
        $this->assertEquals($value, $this->workspace->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->workspace->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->workspace->setRestoredAt($value);
        $this->assertEquals($value, $this->workspace->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->workspace->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->workspace->setRestoredBy($value);
        $this->assertEquals($value, $this->workspace->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->workspace->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->workspace->setRestoredAs($value);
        $this->assertEquals($value, $this->workspace->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->workspace->getColumnMap());
    }
}
