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

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->workspace->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->workspace->setLabel($value);
        $this->assertEquals($value, $this->workspace->getLabel());
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
        $this->assertEquals('current_timestamp()', $this->workspace->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->workspace->getColumnMap());
    }
}
